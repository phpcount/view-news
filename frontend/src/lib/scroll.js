
export function isReachedBottomScroll(partScreen = 25) {
  const offsetHeight = document.body.offsetHeight;
  const screenHeight = window.innerHeight;

  const scrolledPx = window.scrollY;

  const threshold = offsetHeight - screenHeight / partScreen;
  const position = scrolledPx + screenHeight;

  let awaitResolver;
  const awaitPromise = new Promise(resolve => (awaitResolver = resolve));
  if (position > threshold) {
    awaitResolver()
  }

  return awaitPromise
}

export function hasScroll() {
  return document.body.offsetHeight > window.innerHeight;
}

export function scrollUp(scrollTop = 0) {
  document.body.scrollTop = document.documentElement.scrollTop = scrollTop;
}
