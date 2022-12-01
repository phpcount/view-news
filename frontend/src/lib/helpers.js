export function throttle(callee, timeout) {
  let timer = null;

  return function perform(...args) {
    if (timer) return;

    timer = setTimeout(() => {
      callee(...args);

      clearTimeout(timer);
      timer = null;
    }, timeout);
  };
}

export function formatDateTime(date) {
  return new Date(date)
    .toLocaleString('ru-RU', {
      weekday: 'long',
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: 'numeric',
      minute: 'numeric'
    })
}

export function getPageNumber(str) {
  const pattern = new RegExp("page=(?<page>\\d+)");
  const numPage = parseInt(str.match(pattern).groups.page);

  return numPage;
}
