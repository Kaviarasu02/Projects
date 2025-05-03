chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
    if (request.action === "checkPage") {
        chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
            const tab = tabs[0];
            const url = tab.url || "";

            // Check if it's a supported mail page
            if (url.includes("mail.google.com") || url.includes("outlook.live.com") || url.includes("zoho.com")) {
                chrome.tabs.sendMessage(tab.id, { action: "scrapeData" }, async function (data) {
                    if (!data) {
                        sendResponse({ inMailPage: true, summary: null });
                        return;
                    }

                    try {
                        const aiResult = await fetchYourAIModule(data.message);
                        const urlResult = await fetchYourURLValidator(data.urls);
                        const emailResult = await fetchYourEmailScanner(data.headers);

                        sendResponse({
                            inMailPage: true,
                            summary: {
                                ai: aiResult,
                                url: urlResult,
                                email: emailResult
                            }
                        });
                    } catch (err) {
                        console.error("Error in background processing:", err);
                        sendResponse({
                            inMailPage: true,
                            summary: {
                                ai: "Error analyzing message",
                                url: "Error validating URLs",
                                email: "Error scanning headers"
                            }
                        });
                    }
                });

                return true; // ✅ Keep message port open for async `sendResponse`
            } else {
                sendResponse({ inMailPage: false });
            }
        });

        return true; // ✅ Needed at the outermost listener level too
    }
});
