let deferredPrompt: BeforeInstallPromptEvent | null = null;

const installBtn = document.getElementById('installBtn') as HTMLButtonElement;
const iosInstallMsg = document.getElementById(
  'iosInstallMsg',
) as HTMLDivElement;

interface BeforeInstallPromptEvent extends Event {
  readonly platforms: string[];
  readonly userChoice: Promise<{
    outcome: 'accepted' | 'dismissed';
  }>;
  prompt(): Promise<void>;
}

const isIos = (): boolean => {
  const re = /(ipad|iphone|ipod)/g;
  const ua = window.navigator.userAgent.toLowerCase();
  const platform = navigator.platform.toLowerCase();
  return re.test(ua) || re.test(platform);
};

const isInStandaloneMode = (): boolean =>
  window.matchMedia('(display-mode: standalone)').matches ||
  (window.navigator as any).standalone === true;

window.addEventListener('load', () => {
  if (isInStandaloneMode()) {
    return;
  }

  if (isIos()) {
    iosInstallMsg.style.display = 'block';
    installBtn.onclick = () => {
      alert(
        `On iOS:\n1. Tap the Share 📤 button in Safari\n2. Select 'Add to Home Screen'\n3. Launch ${import.meta.env.VITE_APP_NAME || 'Loomkit'} from your Home Screen.`,
      );
    };
  }
});

window.addEventListener('beforeinstallprompt', (e: Event) => {
  e.preventDefault();
  deferredPrompt = e as BeforeInstallPromptEvent;
  installBtn.style.display = 'block';
  installBtn.removeAttribute('hidden');
  installBtn.classList.remove('opacity-0');
  installBtn.classList.add('opacity-100');
});

installBtn.addEventListener('click', async () => {
  if (!deferredPrompt) {
    return;
  }

  await deferredPrompt.prompt();

  const choiceResult = await deferredPrompt.userChoice;
  if (choiceResult.outcome === 'accepted') {
    console.log('✅ User accepted the installation');
  } else {
    console.log('❌ User dismissed the installation');
  }

  deferredPrompt = null;
  installBtn.style.display = 'none';
  installBtn.setAttribute('hidden', '');
  installBtn.classList.remove('opacity-100');
  installBtn.classList.add('opacity-0');
});
