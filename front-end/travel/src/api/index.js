import http from '../plugin/axios'

const PREFIX = "http://test.sev7n.cn/api/"
export const IMAGE_PREFIX = "http://test.sev7n.cn/api/upload/";
export const userLogin = (params) => http.post(`${PREFIX}personal/login.php`, params);
export const userRegister = (params) => http.post(`${PREFIX}personal/register.php`, params);
export const homePicsList = (params) => http.get(`${PREFIX}home/picsList.php`, {params});
export const personalMyCollect = (params) => http.get(`${PREFIX}personal/myCollect.php`, {params});
export const personalMyPics = (params) => http.get(`${PREFIX}personal/myPics.php`, {params});
export const homePicDetail = (params) => http.get(`${PREFIX}home/picDetail.php`, {params});
export const personalAddCollect = (params) => http.post(`${PREFIX}personal/addCollect.php`, params);
export const personalDelete = (params) => http.post(`${PREFIX}personal/delete.php`, params);
export const homePicSearch = (params) => http.get(`${PREFIX}home/picSearch.php`, {params});
export const personalUpload = (params) => http.get(`${PREFIX}personal/upload.php`, {params});
export const homeHotList = (params) => http.get(`${PREFIX}home/hotList.php`, {params});
export const homeCityList = (params) => http.get(`${PREFIX}home/cityList.php`, {params});
export const homeCountryList = (params) => http.get(`${PREFIX}home/countryList.php`, {params});
export const homeBannerList = (params) => http.get(`${PREFIX}home/bannerList.php`, {params});


//个人中心
export const myCollect = (params) => http.get(`${PREFIX}personal/myCollect.php`, {params});
export const myPics = (params) => http.get(`${PREFIX}personal/myPics.php`, {params});
export const uploadUserInfo = (params) => http.post(`${PREFIX}personal/uploadUserInfo.php`, params);
