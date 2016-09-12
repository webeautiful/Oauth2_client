#Oauth2_client使用说明
1.
服务端使用基于[oauth2-server-php](https://github.com/bshaffer/oauth2-server-php)构建的oauth2.0系统

###安装注意事项
1.
若是在类unix系统，需要修改缓存目录`src/Oauth2_client/cache`权限为777

###快速获取资源流程:
1. `cd examples/`

2. `php -S localhost:8080`

3. 正确配置`get_token_by_client.php`, 然后获取token：`php get_token_by_client.php`

4. 正确配置`get_rapid_experience.php`, 然后浏览器访问: `http://localhost:8080/get_rapid_experience.php`即可看到结果
