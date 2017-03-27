# PaperPlane #
一个轻量级的php框架[开发阶段，勿扰]

##1. 路由（route) ##
###1.1固定路由:/module/controller/action ###
<p>
/backend/user/index  -> /backend/UserController/index
在app项目目录下，新建backend模块，该文件夹下是UserController.php，方法为index
get方式：127.0.0.1:8080/backend/user/index?key=value
post方式：127.0.0.1:8080/backend/user/index
在控制器方法中直接$_GET,$_POST就可以接收到数据,后续会统一格式调用，但是直接原生的写仍然可行
</p>

###1.2 完全自定义路由（下个版本） ###
###1.3 自定义与固定路由结合（下个版本） ###
###1.4 三种方式通过路由配置文件中的RouteType方式切换（下个版本） ###

##2.日志  ##
###2.1 记录到文件中（默认） ###
使用方法：\core\lib\Log::log('日志内容'); <br/>
config中配置日志记录方式为文件记录(目前仅支持File)后续会出接口，按照此方式拓展<br/>
记录的内容写入log/log20170710文件中（日期会自动获取当天）
###2.2 redis,memcache,mongodb驱动（下个版本） ###

##3.模型 ##
###3.1 简易模型model ###
可连接不同的数据库，只需在实例化model时候传入配置文件中的名称即可
insert,update,delete,query...模型也是下个版本中重点修改的对象
### 3.2 单例模式，链式操作（下个版本） ###
### 4. 常用对象自动创建，无需手动实例（下个版本） ###
### 5. 配置文件【本地环境，线上环境同时支持】（下个版本） ###
### 6. 请求过滤器（下个版本） ###

    