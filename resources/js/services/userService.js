import http from "./httpService";

const apiEndpointUserList = "/users/";
const apiEndpointSearchUser = "/findUser?q=";
const apiEndpointgetResult = "/users/fetch/q?page=";

export async function getUsers(){
  return http.get(apiEndpointUserList + 'fetch/q');
}

export async function getUser(userId){
  return await http.get(apiEndpointUserList + userId);
}

export async function searchUser(query){
  return await http.get(apiEndpointSearchUser + query);
}

export async function getResult(page){
  return await http.get(apiEndpointgetResult + page);
}

