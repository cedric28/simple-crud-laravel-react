import http from "./httpService";

const apiEndpointEmployeeList = "/employees/";
const apiEndpointSearchEmployee = "/findEmployee?q=";
const apiEndpointgetResult = "/employees/fetch/q?page=";

export async function getEmployees() {
    return http.get(apiEndpointEmployeeList + "fetch/q");
}

export async function getInactiveEmployees() {
    return http.get(apiEndpointEmployeeList + "inactive/fetch/q");
}

export async function deleteEmployee(id) {
    return http.delete(apiEndpointEmployeeList + id + "/archived");
}

export async function restoreEmployee(id) {
    return http.post(apiEndpointEmployeeList + id + "/restore");
}

export async function getEmployee(employeeId) {
    return await http.get(apiEndpointEmployeeList + employeeId);
}

export async function searchEmployee(query) {
    return await http.get(apiEndpointSearchEmployee + query);
}

export async function getResult(page) {
    return await http.get(apiEndpointgetResult + page);
}
