// 📨 Extract mail content, headers, and URLs
function extractMailData() {
    let message = "";
    let headers = "";
    let urls = [];

    // ✅ Try to fetch the message body
    const messageElement = document.querySelector('div[role="textbox"], div[role="document"], .ii.gt');
    if (messageElement) {
        message = messageElement.innerText || messageElement.textContent || "";
        console.log("📨 Message extracted:", message.substring(0, 100));
    } else {
        console.warn("⚠️ Message body not found");
    }

    // ✅ Try to fetch headers (custom Gmail-style selector or fallback)
    const headerElements = document.querySelectorAll('[data-header], .gD, .g2');
    if (headerElements.length > 0) {
        headerElements.forEach(el => {
            headers += el.innerText + "\n";
        });
        console.log("📬 Headers extracted:", headers);
    } else {
        console.warn("⚠️ No headers found");
    }

    // ✅ Extract all links and image URLs
    const links = document.querySelectorAll('a[href]');
    links.forEach(link => {
        urls.push(link.href);
    });

    const imgs = document.querySelectorAll('img[src]');
    imgs.forEach(img => {
        if (img.src.startsWith("http")) {
            urls.push(img.src);
        }
    });

    console.log("🔗 URLs extracted:", urls);

    return { message, headers, urls };
}

// 🚀 Listen for popup requests
chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    if (request.action === "scrapeData") {
        try {
            const data = extractMailData();
            sendResponse(data);
        } catch (err) {
            console.error("❌ Error extracting mail data:", err);
            sendResponse({ message: "", headers: "", urls: [] });
        }
    }
});
