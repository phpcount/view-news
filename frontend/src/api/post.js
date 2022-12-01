import http from '@/api/http';

export async function all({firstPk = null, lastPk = null, limit = null}) {
  const params = {}
  if (firstPk) {
    params['first_pk'] = firstPk
  }
  if (lastPk) {
    params['last_pk'] = lastPk
  }
  if (limit) {
    params['limit'] = limit
  }

  let { data } = await http.get('/post', {
    params,
  });

  return data;
}

export async function one(postId) {
  const { data } = await http.get(`/post/${postId}`, {
    errorAlert: 'при попытке получить новость'
  });

  return data;
}

export async function remove(postId) {
  const { data } = await http.delete(`/post/${postId}`, {
    errorAlert: 'при попытке удалить новость'
  });

  return data;
}

export async function updateRating(postId, rating) {
  const { data } = await http.post(`/post/${postId}/rating`, {
    rating
  }, {
    errorAlert: 'при оценке новости'
  });

  return data;
}
