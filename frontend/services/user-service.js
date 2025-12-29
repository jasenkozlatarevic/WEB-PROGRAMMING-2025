var UserService = {
  init: function () {
    console.log("UserService.init() called");

    UserService.updateNavbar();

    /* ================= LOGIN ================= */
    $(document).off("submit", "#loginForm").on("submit", "#loginForm", function (e) {
      e.preventDefault();

      const entity = {
        email: ($("#loginEmail").val() || "").trim(),
        password: $("#loginPassword").val() || ""
      };

      console.log("LOGIN payload:", entity);

      if (!entity.email || !/^\S+@\S+\.\S+$/.test(entity.email)) {
        return UserService._toastError("Invalid email");
      }
      if (!entity.password || entity.password.length < 4) {
        return UserService._toastError("Password too short");
      }

      UserService.login(entity);
    });

    /* ================= REGISTER ================= */
    $(document).off("submit", "#registerForm").on("submit", "#registerForm", function (e) {
      e.preventDefault();

      const entity = {
        username: ($("#regUsername").val() || "").trim(),
        email: ($("#regEmail").val() || "").trim(),
        password: $("#regPassword").val() || "",
        role: ($("#regRole").val() || "user").trim()
      };

      console.log("REGISTER payload:", entity);

      if (!entity.username || entity.username.length < 2) {
        return UserService._toastError("Username too short");
      }
      if (!entity.email || !/^\S+@\S+\.\S+$/.test(entity.email)) {
        return UserService._toastError("Invalid email");
      }
      if (!entity.password || entity.password.length < 4) {
        return UserService._toastError("Password too short");
      }

      UserService.register(entity);
    });
  },

  /* ================= ROUTE GUARD ================= */
  protectRoute: function () {
    const token = localStorage.getItem("user_token");
    if (!token) {
      window.location.hash = "#login";
      return false;
    }
    return true;
  },

  /* ================= LOGIN ================= */
  login: function (entity) {
    RestClient.post(
      "auth/login",
      entity,
      function (res) {
        console.log("LOGIN RAW RESPONSE:", res);

        if (!res || !res.token) {
          UserService._toastError("Login failed (token missing)");
          return;
        }

        localStorage.setItem("user_token", res.token);
        console.log("TOKEN SAVED:", localStorage.getItem("user_token"));

        UserService._toastSuccess("Logged in successfully");
        UserService.updateNavbar();

        window.location.hash = "#notes";
      },
      function (xhr) {
        UserService._toastError(
          xhr?.responseJSON?.error ||
          xhr?.responseText ||
          "Login failed"
        );
      }
    );
  },

  /* ================= REGISTER ================= */
  register: function (entity) {
    RestClient.post(
      "auth/register",
      entity,
      function () {
        UserService._toastSuccess("Registered successfully");
        UserService.login({
          email: entity.email,
          password: entity.password
        });
      },
      function (xhr) {
        UserService._toastError(
          xhr?.responseJSON?.error ||
          xhr?.responseText ||
          "Register failed"
        );
      }
    );
  },

  /* ================= LOGOUT ================= */
  logout: function () {
    localStorage.removeItem("user_token");
    // Clear profile fields
    $("#profileUsername").text("-");
    $("#profileEmail").text("-");
    $("#profileRole").text("-");
    UserService.updateNavbar();
    window.location.hash = "#login";
  },

  /* ================= NAVBAR VISIBILITY ================= */
  updateNavbar: function () {
    const token = localStorage.getItem("user_token");

    if (token) {
      $(".nav-login, .nav-register").hide();
      $(".nav-notes, .nav-profile, .nav-logout").show();
    } else {
      $(".nav-login, .nav-register").show();
      $(".nav-notes, .nav-profile, .nav-logout").hide();
    }
  },

  /* ================= PROFILE ================= */
  populateProfile: function () {
    const token = localStorage.getItem("user_token");

    if (!token) {
      // Clear profile fields when not logged in
      $("#profileUsername").text("-");
      $("#profileEmail").text("-");
      $("#profileRole").text("-");
      console.warn("No token found");
      return;
    }

    const payload = Utils.parseJwt(token);

    if (!payload || !payload.user) {
      // Clear on invalid token
      $("#profileUsername").text("-");
      $("#profileEmail").text("-");
      $("#profileRole").text("-");
      console.warn("Invalid token payload");
      return;
    }

    $("#profileUsername").text(payload.user.username || "-");
    $("#profileEmail").text(payload.user.email || "-");
    $("#profileRole").text(payload.user.role || "-");
  },


  /* ================= TOAST HELPERS ================= */
  _toastSuccess: function (msg) {
    toastr ? toastr.success(msg) : alert(msg);
  },

  _toastError: function (msg) {
    toastr ? toastr.error(msg) : alert(msg);
  }
};
