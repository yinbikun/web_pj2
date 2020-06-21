import TravelHome from "../views/TravelHome"
import TravelList from "../views/TravelList"
import TravelDetail from "../views/TravelDetail"
import TravelSearch from "../views/TravelSearch"
import MyLove from "../views/TravelProfile/MyLove"
import MyPhoto from "../views/TravelProfile/MyPhoto"
import PictureUploader from "../views/TravelProfile/PictureUploader"

export default [{
  path: "home",
  name: "Home",
  component: TravelHome
}, {
  path: "list",
  name: "List",
  component: TravelList
}, {
  path: "detail",
  name: "Detail",
  component: TravelDetail
}, {
  path: "search",
  name: "Search",
  component: TravelSearch
}, {
  path: "love",
  name: "Love",
  component: MyLove
}, {
  path: "photo",
  name: "Photo",
  component: MyPhoto
}, {
  path: "upload",
  name: "Upload",
  component: PictureUploader
},]