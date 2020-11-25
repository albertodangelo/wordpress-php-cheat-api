/**
 * Configuration for OAuth2 and REST API requests.
 *
 * NOT FOR PRODUCTION. PURELY FOR DEMONSTRATION PURPOSES!
 */

const rootURL = "http://localhost:8001/index.php";

const config = {
  rootURL: rootURL,
  taskRoute: `${rootURL}/wp-json/wp/v2/tasks/`,
  responseType: "token",
  tokenName: "taskAppToken",
  tokenExpiry: "",
};

export default config;
