Site Building Framework MEI
=======

## 소개

* 개발 언어 : PHP 5.3+ / MySQL 5.0+
* 서비스 환경 : 크로스 플랫폼, Apache / IIS / Nginx / 그외 PHP 대응하는 웹서버 / UTF-8 / 크로스브라우징 지원
* Github : https://github.com/syakuis/php-mei
* 공식 카페 : http://cafe.naver.com/phpmei
* 설치하기 : http://cafe.naver.com/phpmei/4
* 메뉴얼 : 공식카페에 업데이트 됩니다.

MEI (Modularize. Extension. Interaction.) 란? 웹프로그램을 모듈화하여 여러 모듈들이 서로 연결되어 하나의 플랫폼이 완성되는 것을 도와주는 사이트 빌딩 프레임워크입니다. 또한 레이아웃과 스킨을 자유롭게 변경할 수 있어 다양한 디자인과 UI를 표현할 수 있어 어떤 모듈의 구성에 따라 웹사이트가 되고 쇼핑몰 혹은 블로그, 카페 사이트로 시스템 구성을 할 수 있습니다.


* Modularize : 한번 개발된 프로그램은 재사용이 용의하게 모듈화 합니다.
* Extension : 모듈은 세분화되어 특정 프로그램에 구애받지 않아 확장성에 용의합니다.
* Interaction : 모듈 간의 상호작용이 효율적이며 손쉽게 필요한 모듈을 호출할 수 있습니다.


MEI 에는 다음과 같은 기능을 제공합니다.

* MySQL 5.0 이상 데이터베이스 커넥션을 제공합니다.
* MVC 모델 패턴을 지원하며, 자원을 낭비하는 불필요한 템플릿엔진을 사용하지 않고 PHP 그대로를 사용합니다.
* 프로그램들이 각각 모듈화되어 있어, 필요에 따라 조립하는 방식으로 다양한 결과를 만들어낼 수 있습니다.
* 스킨과 레이아웃을 기능을 제공하여 원하는 UI와 디자인으로 구성할 수 있습니다.
* 모듈이 실행되기 전과 후를 처리하는 인터셉터를 지원합니다.
* 개발된 모듈은 모바일용 스킨과 레아웃만 추가하면 손쉽게 모바일 환경도 구성할 수 있습니다.
* 모듈마다 설정정보를 가지므로 유동적인 모듈의 기능을 가질 수 있습니다.

## 설치하기

1. MEI 설치하기 위해서는 PHP 5.3 이상 과 PHP 대응하는 웹서버(Apache , IIS, Nigx) 그리고 MySQL 5.0 이상이 필요합니다.
2. MEI 를 내려받아 웹서비스에 압축을 풀어주세요.
3. 브라우져를 통해 웹서비스에 접속하세요.
4. 인스톨을 진행하시면 됩니다.


## Built-in Open Source

사용된 오픈소스는 아래와 같습니다.

* jQuery

* jQuery Action

* jQuery-ui
* jQuery-mobile
* Bootstrap

* SWFUpload
* SmartEditor
* CKEditor

