import http from '@/api/http';

export async function start(delay = 0) {

  let { data } = await http.get('/news/collector/start', {
    errorAlert: 'при запуске процесса парсинга новостей',
    params: {
      delay
    },
  });

  return data;
}

export async function state() {

  let { data } = await http.get('/news/collector/state', {
    errorAlert: 'при получении состояния парсинга',
  });

  return data;
}

export async function changeDelay(delay = 0) {

  let { data } = await http.post('/news/collector/delay', { delay }, {
    errorAlert: 'при задержке в парсинге новостей',
  });

  return data;
}


export async function stop() {

  let { data } = await http.get('/news/collector/stop', {
    errorAlert: 'при остановке парсера новостей',
  });

  return data;
}
