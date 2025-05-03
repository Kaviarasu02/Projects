import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from xgboost import XGBClassifier
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix
import seaborn as sns
import matplotlib.pyplot as plt
import pickle

# Load dataset
df = pd.read_csv("final_combined_dataset.csv")

# Drop NaN labels
df = df.dropna(subset=['label'])

# Remove underrepresented classes (fewer than 2 samples)
label_counts = df['label'].value_counts()
valid_labels = label_counts[label_counts >= 2].index
df = df[df['label'].isin(valid_labels)]

# Fill NaN text
df['text_combined'] = df['text_combined'].fillna('')

# Vectorization
vectorizer = TfidfVectorizer(stop_words='english', max_features=10000)
X = vectorizer.fit_transform(df['text_combined'])

# Convert label to integer
y = df['label'].astype(int)

# Stratified train/test split
x_train, x_test, y_train, y_test = train_test_split(
    X, y, test_size=0.2, stratify=y, random_state=42
)

# Model
model = XGBClassifier(
    n_estimators=200,
    max_depth=6,
    learning_rate=0.1,
    subsample=0.8,
    colsample_bytree=0.8,
    eval_metric='logloss',
)
model.fit(x_train, y_train)

# Predict
y_pred = model.predict(x_test)

# Evaluation
acc = accuracy_score(y_test, y_pred)
print(f"\n✅ Accuracy: {acc * 100:.2f}%")
print("\nClassification Report:\n", classification_report(y_test, y_pred))

# Confusion matrix
cm = confusion_matrix(y_test, y_pred)
sns.heatmap(cm, annot=True, fmt='d', cmap='Blues')
plt.xlabel("Predicted")
plt.ylabel("Actual")
plt.title("Confusion Matrix")
plt.show()

# Save model & vectorizer
pickle.dump(model, open('xgb_model.pkl', 'wb'))
pickle.dump(vectorizer, open('tfidf_vectorizer.pkl', 'wb'))

print("\n✅ Model and vectorizer saved successfully!")
