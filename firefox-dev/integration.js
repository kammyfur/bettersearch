globalThis.extension = {
    version: "0.6",
    platform: "Firefox",
    system: navigator.platform,
}

console.log("[bsext] Successfully loaded BetterSearch integration interface...");

window.onload = () => {
    document.querySelector("[title='Hosted on free web hosting 000webhost.com. Host your own website for FREE.']").offsetParent.classList.add('hide');
    console.log("[bsext] Initialised visual enhancements");
}