import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import TfidfVectorizer
from xgboost import XGBClassifier
from sklearn.metrics import accuracy_score, classification_report
import pickle

# Load cleaned dataset (make sure it has 'text_combined' and 'label' columns)
df = pd.read_csv("final_combined_dataset.csv")  # your combined cleaned dataset

# Optional: print rows/columns and sample data
print(f"Rows: {df.shape[0]}, Columns: {df.shape[1]}")
print(df.head())

# Vectorize the combined email text
vectorizer = TfidfVectorizer(stop_words='english', max_features=10000)
df['text_combined'] = df['text_combined'].fillna('')
X = vectorizer.fit_transform(df['text_combined'])
y = df['label']

# Train/test split
x_train, x_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Train model (without `use_label_encoder`)
model = XGBClassifier(eval_metric='logloss')  # Removed the 'use_label_encoder' parameter
model.fit(x_train, y_train)

# Predict and evaluate
y_pred = model.predict(x_test)
acc = accuracy_score(y_test, y_pred)

print(f"\n✅ Model Accuracy: {acc * 100:.2f}%")
print("\nClassification Report:\n", classification_report(y_test, y_pred))

# Save the trained model and vectorizer
pickle.dump(model, open('xgb_model.pkl', 'wb'))
pickle.dump(vectorizer, open('tfidf_vectorizer.pkl', 'wb'))

print("\n✅ Model and vectorizer saved successfully!")