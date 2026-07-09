/**
 * BrowserSync config - proxy ke XAMPP dengan auto-refresh
 * Jalankan: npx browser-sync start -c bs-config.js
 */
module.exports = {
  proxy: {
    target: "http://localhost/new-crew-system",
    proxyOptions: {
      xfwd: true // Kirim X-Forwarded-Host, X-Forwarded-For ke backend
    }
  },
  port: 3000,
  files: [
    "application/**/*.php",
    "assets/**/*.css",
    "assets/**/*.js"
  ],
  open: false,
  notify: false
};