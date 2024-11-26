#python
import os
import numpy as np
import librosa
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, classification_report
import joblib
from tqdm import tqdm
import warnings

# Suppress warnings
warnings.filterwarnings("ignore")

def extract_features(file_path, n_mfcc=40, n_fft=2048, hop_length=512):
    try:
        audio, sr = librosa.load(file_path, res_type='kaiser_fast')
        mfccs = librosa.feature.mfcc(y=audio, sr=sr, n_mfcc=n_mfcc, n_fft=n_fft, hop_length=hop_length)
        return np.mean(mfccs.T, axis=0)
    except Exception as e:
        print(f"Error extracting features from {file_path}: {str(e)}")
        return None

def load_dataset(dataset_path):
    features = []
    labels = []
    emotion_classes = ['neutral', 'depressed', 'happy', 'sad', 'angry', 'surprised']
    
    for label in emotion_classes:
        class_path = os.path.join(dataset_path, label)
        if not os.path.isdir(class_path):
            print(f"Warning: Directory for {label} not found.")
            continue
        for audio_file in tqdm(os.listdir(class_path), desc=f"Processing {label}"):
            file_path = os.path.join(class_path, audio_file)
            feature = extract_features(file_path)
            if feature is not None:
                features.append(feature)
                labels.append(label)
    return np.array(features), np.array(labels)

def main():
    # Path to your dataset
    dataset_path = r"C:\Users\New Classic\Desktop\AI and ML\Data Set"
    
    print("Loading and processing the dataset...")
    X, y = load_dataset(dataset_path)
    
    if len(X) == 0:
        print("No valid audio files found. Please check your dataset.")
        return
    
    # Encode labels
    le = LabelEncoder()
    y = le.fit_transform(y)
    
    # Split the dataset
    X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
    
    print("Training the model...")
    model = RandomForestClassifier(n_estimators=100, random_state=42, n_jobs=-1)
    model.fit(X_train, y_train)
    
    print("Evaluating the model...")
    y_pred = model.predict(X_test)
    accuracy = accuracy_score(y_test, y_pred)
    print(f"Model accuracy: {accuracy:.2f}")
    
    print("\nClassification Report:")
    print(classification_report(y_test, y_pred, target_names=le.classes_))
    
    print("Saving the model and label encoder...")
    joblib.dump(model, 'audio_classification_model.joblib')
    joblib.dump(le, 'label_encoder.joblib')
    print("Model and label encoder saved successfully.")

if __name__ == "__main__":
    main()

