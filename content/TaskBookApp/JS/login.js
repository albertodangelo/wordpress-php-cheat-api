import config from "./modules/config.js";

/**
 * Login script.
 *
 * When Login button is clicked, browser navigates to the WP login
 * page with client_id and response_type in the URL query.
 *
 * @package Taskbook
 */

const login = document.querySelector("#loginform");

login.addEventListener("submit", (e) => {
  e.preventDefault();
  let username = document.querySelector("#user_login").value;
  let password = document.querySelector("#user_pass").value;

  console.info(`Username: ${username} Password: ${password}`);

  let restURL = `${config.rootURL}/index.php/wp-json/jwt-auth/v1/token`;

  // The POST request to get the token.
  const response = fetch(restURL, {
    method: "POST",
    body: JSON.stringify({
      username: username,
      password: password,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((response) => {
      // If we get a token in response (username and password match).
      if (response.token) {
        // Toggle various things on and off.
        console.log("getToken: ", response.token);
        sessionStorage.setItem(config.tokenName, response.token);
        config.token = response.token;
        // Get the current time.
        sessionStorage.setItem(
          "tokenExpiry",
          Math.round(new Date().getTime() / 1000) + 3600
        );
        window.location = window.location.origin + "/index.html";
      }
    })
    .catch((error) => {
      console.error("getToken error: ", error);
    });
});
