document.addEventListener('DOMContentLoaded', function () {
    const statusDiv = document.getElementById('status');
    const resultDiv = document.getElementById('result');
    const loader = document.getElementById('loader');
    const toast = document.getElementById('toast');
    const themeToggle = document.getElementById('themeToggle');
  
    function showLoader(show) {
      loader.style.display = show ? 'block' : 'none';
    }
  
    function showToast(message, type = 'success') {
      toast.textContent = message;
      toast.className = `toast ${type}`;
      toast.style.display = 'block';
      setTimeout(() => {
        toast.style.display = 'none';
      }, 3000);
    }
  
    function applyTheme(darkMode) {
      document.documentElement.style.setProperty('--bg-main', darkMode ? '#1a1a2e' : '#f5f6fa');
      document.documentElement.style.setProperty('--bg-secondary', darkMode ? '#16213e' : '#ddd');
      document.documentElement.style.setProperty('--text', darkMode ? '#f5f6fa' : '#111');
      showToast(darkMode ? 'Dark mode enabled 🌙' : 'Light mode enabled ☀️');
    }
  
    if (themeToggle) {
      themeToggle.addEventListener('change', () => {
        applyTheme(themeToggle.checked);
      });
      applyTheme(themeToggle.checked); // apply on load
    }
  
    chrome.runtime.sendMessage({ action: "checkPage" }, function (response) {
      if (!response || !response.inMailPage) {
        statusDiv.textContent = "⚠ Not in a mail page.";
        showToast("You're not in a supported mail page! Switch to Mail Page", "error");
        return;
      }
  
      statusDiv.textContent = "✅ Mail page detected. Analyzing...";
      showLoader(true);
  
      if (response.summary) {
        const { ai, url, email } = response.summary;
        resultDiv.innerHTML = `
          <strong>🤖 AI Analysis:</strong><br>${ai}<br><br>
          <strong>🔗 URL Validation:</strong><br>${url}<br><br>
          <strong>📬 Email Scan:</strong><br>${email}
        `;
        resultDiv.style.display = "block";
        showToast("Analysis complete ✅", "success");
      } else {
        resultDiv.innerHTML = "No data found to analyze.";
        resultDiv.style.display = "block";
        showToast("No analysis data 😕", "error");
      }
  
      showLoader(false);
    });
  });
  