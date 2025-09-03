let deferredPrompt;
const installBtn = document.getElementById('installBtn');
const iosInstallMsg = document.getElementById('iosInstallMsg');

function getPlatformIcon() {
  const platform = navigator.platform.toLowerCase();
  if (/mac|iphone|ipad|ipod/.test(platform)) {
    return '🍏 Darwin';
  }
  if (/win/.test(platform)) {
    return '🪟 Windows';
  }
  if (/linux/.test(platform)) {
    return '🐧 Linux';
  }
  return '❓ Unknown';
}

const isIos = () => {
  const ua = window.navigator.userAgent.toLowerCase();
  return /iphone|ipad|ipod/.test(ua);
};

const isInStandaloneMode = () =>
  window.matchMedia('(display-mode: standalone)').matches ||
  window.navigator.standalone === true;

console.log('Platform:', getPlatformIcon());

window.addEventListener('load', () => {
  if (isInStandaloneMode()) {
    return; // already installed
  }

  if (isIos()) {
    iosInstallMsg.style.display = 'block';
  }
});

window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e;
  installBtn.style.display = 'block';
});

installBtn.addEventListener('click', async () => {
  if (!deferredPrompt) {
    return;
  }

  deferredPrompt.prompt(); // Show native install dialog

  const { outcome } = await deferredPrompt.userChoice;
  if (outcome === 'accepted') {
    console.log('User accepted the installation');
  } else {
    console.log('User dismissed the installation');
  }

  deferredPrompt = null;
  installBtn.style.display = 'none';
});
