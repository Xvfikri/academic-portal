import './bootstrap';

/**
 * Notification dropdown (dummy)
 * - toggle open/close
 * - click outside closes
 * - ESC closes
 * - mark all read updates UI
 */
document.addEventListener('DOMContentLoaded', () => {
  const wrap = document.getElementById('notifWrap');
  const btn = document.getElementById('notifBtn');
  const panel = document.getElementById('notifPanel');
  const badge = document.getElementById('notifBadge');
  const markAll = document.getElementById('notifMarkAll');
  const unreadText = document.getElementById('notifUnreadText');

  if (!wrap || !btn || !panel) return;

  const open = () => panel.classList.remove('hidden');
  const close = () => panel.classList.add('hidden');
  const isOpen = () => !panel.classList.contains('hidden');

  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    isOpen() ? close() : open();
  });

  document.addEventListener('click', (e) => {
    if (!isOpen()) return;
    if (!wrap.contains(e.target)) close();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen()) close();
  });

  markAll?.addEventListener('click', () => {
    const items = panel.querySelectorAll('.notifItem');

    items.forEach((it) => {
      it.dataset.unread = '0';
      it.classList.remove('bg-slate-50/60');

      // dot element = div pertama setelah container -> punya class w-2.5 h-2.5
      const dot = it.querySelector('div.w-2\\.5.h-2\\.5');
      if (dot) {
        dot.classList.remove('bg-blue-500');
        dot.classList.add('bg-transparent');
      }
    });

    if (badge) badge.remove();
    if (unreadText) unreadText.textContent = '0';
  });
});
