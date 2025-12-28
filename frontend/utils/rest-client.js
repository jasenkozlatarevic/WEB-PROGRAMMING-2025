var RestClient = {
  get: function (url, success, error) {
    $.ajax({
      url: Constants.API_BASE_URL + url,
      type: "GET",
      beforeSend: function (xhr) {
        const token = localStorage.getItem("user_token");
        if (token) {
          xhr.setRequestHeader("Authorization", "Bearer " + token);
        }
      },
      success: success,
      error: error
    });
  },

  post: function (url, data, success, error) {
    $.ajax({
      url: Constants.API_BASE_URL + url,
      type: "POST",
      data: JSON.stringify(data),
      contentType: "application/json",
      beforeSend: function (xhr) {
        const token = localStorage.getItem("user_token");
        if (token) {
          xhr.setRequestHeader("Authorization", "Bearer " + token);
        }
      },
      success: success,
      error: error
    });
  },

  put: function (url, data, success, error) {
    $.ajax({
      url: Constants.API_BASE_URL + url,
      type: "PUT",
      data: JSON.stringify(data),
      contentType: "application/json",
      beforeSend: function (xhr) {
        const token = localStorage.getItem("user_token");
        if (token) {
          xhr.setRequestHeader("Authorization", "Bearer " + token);
        }
      },
      success: success,
      error: error
    });
  },

  put: function (url, data, success, error) {
    $.ajax({
      url: Constants.API_BASE_URL + url,
      type: "PUT",
      data: JSON.stringify(data),
      contentType: "application/json",
      beforeSend: function (xhr) {
        const token = localStorage.getItem("user_token");
        if (token) {
          xhr.setRequestHeader("Authorization", "Bearer " + token);
        }
      },
      success: success,
      error: error
    });
  },

  delete: function (url, success, error) {
    $.ajax({
      url: Constants.API_BASE_URL + url,
      type: "DELETE",
      beforeSend: function (xhr) {
        const token = localStorage.getItem("user_token");
        if (token) {
          xhr.setRequestHeader("Authorization", "Bearer " + token);
        }
      },
      success: success,
      error: error
    });
  }
};
