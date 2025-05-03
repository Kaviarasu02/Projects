import tldextract

# Function to extract root domain
def get_root_domain(url):
    extracted = tldextract.extract(url)
    return f"{extracted.domain}.{extracted.suffix}".lower()

# Read blacklist file
with open("URL_blacklists.txt", "r") as file:
    blacklist = [line.strip() for line in file if line.strip()]

# Extract domains from blacklist
blacklist_domains = set(get_root_domain(url) for url in blacklist)

# Take input URL
input_url = input("Enter a URL to check: ").strip()
input_domain = get_root_domain(input_url)

# Check and report
if input_domain in blacklist_domains:
    print("malicious")
else:
    print("safe")
