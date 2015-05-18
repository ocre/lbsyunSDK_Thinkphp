# lbsyunSDK_Thinkphp
tools for using <a href="http://api.map.baidu.com/lbsapi/cloud/lbs-cloud.htm">baidu lbs cloud api</a>

请先创建服务端应用，选择SN校验方式，获取AK(Access Key)和SK(Secure Key)。

Test GeoCoding:
 http://www.xxx.com/index.php/Home/GeoCoding/testGetCoord/address/%E5%A4%A9%E5%AE%89%E9%97%A8

* 根据数据库里医院详细地址设置对应的坐标。
   http://www.xxx.com/index.php/Home/GeoCoding/setHospitalCoords


* 把数据库里带坐标的医院数据索引到百度LBS云存储。
   http://www.xxx.com/index.php/Home/GeoData/indexHospitals

* 查询附近的医院，按距离由近及远排序
   http://www.xxx.com/index.php/Home/Hospital/around


