let Utils = {
  parseJwt: function (token) {
    if (!token) return null;
    try {
      const payload = token.split(".")[1];
      const decoded = atob(payload);
      return JSON.parse(decoded);
    } catch (e) {
      console.error("Invalid JWT token", e);
      return null;
    }
  },

  showError: function (msg) {
    if (typeof toastr !== "undefined") toastr.error(msg);
    else alert(msg);
  },

  showSuccess: function (msg) {
    if (typeof toastr !== "undefined") toastr.success(msg);
    else alert(msg);
  }
};
