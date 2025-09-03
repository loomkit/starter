let deferredPrompt: BeforeInstallPromptEvent | null = null;

const installBtn = document.getElementById('installBtn') as HTMLButtonElement;
const iosInstallMsg = document.getElementById(
  'iosInstallMsg',
) as HTMLDivElement;

interface BeforeInstallPromptEvent extends Event {
  readonly platforms: string[];
  readonly userChoice: Promise<{
    outcome: 'accepted' | 'dismissed';
    platform: string;
  }>;
  prompt(): Promise<void>;
}

const getPlatformIcon = (): string => {
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
};

const isIos = (): boolean => {
  const ua = window.navigator.userAgent.toLowerCase();
  return /iphone|ipad|ipod/.test(ua);
};

const isInStandaloneMode = (): boolean =>
  window.matchMedia('(display-mode: standalone)').matches ||
  (window.navigator as any).standalone === true;

console.log('Platform:', getPlatformIcon());

window.addEventListener('load', () => {
  if (isInStandaloneMode()) {
    return;
  }

  if (isIos()) {
    iosInstallMsg.style.display = 'block';
  }
});

window.addEventListener('beforeinstallprompt', (e: Event) => {
  e.preventDefault();
  deferredPrompt = e as BeforeInstallPromptEvent;
  installBtn.style.display = 'block';
});

installBtn.addEventListener('click', async () => {
  if (!deferredPrompt) {
    return;
  }

  await deferredPrompt.prompt();

  const choiceResult = await deferredPrompt.userChoice;
  if (choiceResult.outcome === 'accepted') {
    console.log('User accepted the installation');
  } else {
    console.log('User dismissed the installation');
  }

  deferredPrompt = null;
  installBtn.style.display = 'none';
});
