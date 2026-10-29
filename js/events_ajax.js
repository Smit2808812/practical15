document.addEventListener("DOMContentLoaded", function () {
document.querySelectorAll(".ajax-register-form").forEach(function (form) {
form.addEventListener("submit", async function (event) {
event.preventDefault();
const button = form.querySelector('button[type="submit"]');
const message = form.querySelector(".ajax-message");
if (!button || !message || button.disabled) return;
const originalText = button.textContent.trim();
button.disabled = true;
button.textContent = "Registering...";
message.textContent = "";
try {
const response = await fetch(form.action, {
method: "POST",
body: new FormData(form),
headers: { "X-Requested-With": "XMLHttpRequest", "Accept": "application/json" }
});
const result = await response.json();
message.textContent = result.message || "Request completed.";
if (response.ok && result.success) {
message.style.color = "#16834a";
button.textContent = "✓ Registered";
} else {
message.style.color = "#c6283d";
button.disabled = false;
button.textContent = originalText;
}
} catch (error) {
message.textContent = "Connection error. Please try again.";
message.style.color = "#c6283d";
button.disabled = false;
button.textContent = originalText;
}
});
});
});
