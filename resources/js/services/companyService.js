import http from "./httpService";

const apiEndpointCompanyList = "/companies/";
const apiEndpointSearchCompany = "/findCompany?q=";
const apiEndpointgetResulCompany = "/fetch/q?page=";

export async function deleteCompany(id) {
    return http.delete(apiEndpointCompanyList + id + "/archived");
}

export async function restoreCompany(id) {
    return http.post(apiEndpointCompanyList + id + "/restore");
}

export async function getCompanies() {
    return http.get(apiEndpointCompanyList + "fetch/q");
}

export async function getCompany(companyId) {
    return await http.get(apiEndpointCompanyList + companyId);
}

export async function searchCompany(query) {
    return await http.get(apiEndpointSearchCompanyyhu + query);
}

export async function getResult(page) {
    return await http.get(apiEndpointgetResult + page);
}
