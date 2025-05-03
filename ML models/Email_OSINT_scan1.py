import requests
from bs4 import BeautifulSoup
import re
import time

EMAIL_SERVICES = {
    "Twitter": "https://twitter.com/account/begin_password_reset?email={}",
    "GitHub": "https://github.com/password_reset",
}

HEADERS = {
    "User-Agent": "Mozilla/5.0"
}

def check_twitter(email):
    url = EMAIL_SERVICES["Twitter"].format(email)
    res = requests.get(url, headers=HEADERS)
    return "email_sent" in res.text or "We sent you" in res.text

def check_github(email):
    res = requests.post(EMAIL_SERVICES["GitHub"], data={"email": email}, headers=HEADERS)
    return "email has been sent" in res.text

def check_haveibeenpwned(email):
    url = f"https://haveibeenpwned.com/unifiedsearch/{email}"
    headers = HEADERS.copy()
    headers["Accept"] = "application/json"
    try:
        res = requests.get(url, headers=headers)
        if res.status_code == 200 and "Breaches" in res.text:
            return [breach["Name"] for breach in res.json().get("Breaches", [])]
    except:
        pass
    return []

def check_snusbase(email):
    try:
        query = f"https://www.google.com/search?q=site:snusbase.com+{email}"
        res = requests.get(query, headers=HEADERS)
        soup = BeautifulSoup(res.text, "html.parser")
        results = []
        for g in soup.find_all("div", class_="BVG0Nb"):
            link = g.find("a", href=True)
            if link:
                results.append(link['href'])
        return results
    except:
        return []

def hunter_search(email):
    try:
        domain = email.split("@")[-1]
        url = f"https://hunter.io/email-finder/{domain}"
        res = requests.get(url, headers=HEADERS)
        soup = BeautifulSoup(res.text, "html.parser")
        results = []
        for a in soup.find_all("a", href=True):
            if "mailto:" in a['href']:
                results.append(a['href'].replace("mailto:", ""))
        return list(set(results))
    except:
        return []

def google_dorks(email):
    query = f'"{email}"'
    url = f"https://www.google.com/search?q={query}"
    res = requests.get(url, headers=HEADERS)
    soup = BeautifulSoup(res.text, "html.parser")
    results = []
    for g in soup.find_all("div", class_="BVG0Nb"):
        link = g.find("a", href=True)
        if link:
            results.append(link['href'])
    return results

def scan_email(email):
    print(f"[+] Scanning: {email}")

    print("\n[*] Checking social media platforms:")
    print(f"  - Twitter: {'Possible account' if check_twitter(email) else 'No result'}")
    print(f"  - GitHub: {'Possible account' if check_github(email) else 'No result'}")

    print("\n[*] Checking breaches (HaveIBeenPwned):")
    breaches = check_haveibeenpwned(email)
    if breaches:
        for b in breaches:
            print(f"  - Found in: {b}")
    else:
        print("  - No breach data found or blocked")

    print("\n[*] Public leaks (Snusbase via Google):")
    leaks = check_snusbase(email)
    if leaks:
        for l in leaks[:5]:
            print(f"  - {l}")
    else:
        print("  - No paste/leak found")

    print("\n[*] Domain-related emails (Hunter.io public fallback):")
    hunter = hunter_search(email)
    if hunter:
        for h in hunter:
            print(f"  - {h}")
    else:
        print("  - No public emails found on domain")

    print("\n[*] Public exposure (Google):")
    links = google_dorks(email)
    if links:
        for l in links[:5]:
            print(f"  - {l}")
    else:
        print("  - No public references found.")

if __name__ == "__main__":
    target_email = input("Enter email to scan: ").strip()
    scan_email(target_email)
