import axios from "axios";


export const axiosInstance =

  axios.create({

    baseURL: `https://xx.hmaserv.online/assos/api`,
    headers: {
      'device-id': localStorage.getItem("device-id") || "",
      'accept-language': localStorage.getItem("i18nextLng") || "en",
      'country': localStorage.getItem("country") || "ku",
      'main-filter': localStorage.getItem("main-filter") || "men",
      "Authorization": `Bearer ${localStorage.getItem("api-token") || ""}`
    },
    params: {
      api_token: localStorage.getItem("api-token") || "",
    }
  });


// axiosInstance.interceptors.request.use(function (config) {

//    config.headers["Authorization"] = "Bearer " +localStorage.getItem("api-token") ;

//   console.log(config)
//   return config;
// }, function (error) {

//   return Promise.reject(error);
// })
