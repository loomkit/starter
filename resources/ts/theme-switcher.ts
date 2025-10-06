document.addEventListener('DOMContentLoaded', () => {
  const switcher = document.getElementById('themeSwitcher');

  if (switcher) {
    const themeIs = (theme: string) =>
      document.documentElement.classList.contains(theme) ||
      localStorage.getItem('theme') === theme ||
      (!('theme' in localStorage) &&
        window.matchMedia(`(prefers-color-scheme: ${theme})`).matches);

    const isDarkMode = () => themeIs('dark');

    const useSystemTheme = () => {
      localStorage.removeItem('theme');
      document.documentElement.classList.remove('dark', 'light');
      switcher.innerHTML = '🌗';
    };

    const useDarkTheme = () => {
      localStorage.setItem('theme', 'dark');
      document.documentElement.classList.remove('light');
      document.documentElement.classList.add('dark');
      switcher.innerHTML = '☀️';
    };

    const useLightTheme = () => {
      localStorage.setItem('theme', 'light');
      document.documentElement.classList.remove('dark');
      document.documentElement.classList.add('light');
      switcher.innerHTML = '🌙';
    };

    isDarkMode()
      ? useDarkTheme()
      : themeIs('light')
        ? useLightTheme()
        : useSystemTheme();

    const toggleTheme = () => {
      isDarkMode() ? useLightTheme() : useDarkTheme();
    };

    const darkModeEvent = new Event('dark-mode');

    switcher.addEventListener('click', () => {
      toggleTheme();
      document.dispatchEvent(darkModeEvent);
    });
  }
});
