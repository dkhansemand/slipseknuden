var app = angular.module('slipseknuden', ['ngRoute']);

/*
 * Define routes with controller and templat.
 * Default route set to "hjem" if the route don't exist
 */

app.config(function($routeProvider) {
    $routeProvider
    .when('/Hjem', {
        controller: 'homeControl',
        templateUrl : './assets/views/home.html'    
    })
    .when('/Om-Slipseknuden', {
        controller: 'aboutControl',
        templateUrl : './assets/views/about.html'
    })
    .when('/Garanti', {
        controller: 'guaranteeControl',
        templateUrl : './assets/views/guarantee.html'
    })
    .when('/Kontakt', {
        controller: 'contactControl',
        templateUrl : './assets/views/contact.html'
    })
    .when('/Nyheder', {
        controller: 'newsControl',
        templateUrl : './assets/views/news.html'
    })
    .when('/Nyhed/:ID', {
        controller: 'newsViewControl',
        templateUrl : './assets/views/newsView.html'
    })
    .when('/Produkter/:CATID', {
        controller: 'productControl',
        templateUrl : './assets/views/products.html'
    })
    .when('/Produkt/:ID', {
        controller: 'productViewControl',
        templateUrl : './assets/views/productView.html'
    })
    .when('/Soeg/:SEARCH', {
        controller: 'searchViewControl',
        templateUrl : './assets/views/search.html'
    })
    .otherwise({
        redirectTo: '/Hjem'
    });
});

app.controller('navController', function($scope, $location){
    $scope.isActive = function(route) {
        return route === $location.path();
    }
});

app.controller('categoryController', function($scope, $http){
    "use strict";
    $http.get("./assets/lib/dataHandler.php?categories")
    .then(function (response) {
        "use strict";
        $scope.categories = response.data;
        console.log(response);    
    });
});

app.controller('homeControl', function ($scope, $http) {
    "use strict";
    $http.get("./assets/lib/dataHandler.php?home")
    .then(function (response) {
        "use strict";
        if(!response.data.error){
            $scope.pageContent = response.data.pageDetailsText;
            $scope.pageTitle = response.data.pageDetailsTitle;    
            //console.log(response);    
        }else{
            $scope.pageTitle = 'Fejl: ' + response.data.error;
        }
    });
});

app.controller('aboutControl', function ($scope) {
    
});

app.controller('guaranteeControl', function ($scope) {
    
});

app.controller('contactControl', function ($scope) {
    
});

app.controller('newsControl', function ($scope) {
    
});

app.controller('newsViewControl', function ($scope) {
    
});

app.controller('productControl', function ($scope, $routeParams) {
    var categoryID = $routeParams.CATID;
    $http.get("./assets/lib/dataHandler.php?products&categoryId="+categoryID)
    .then(function (response) {
        "use strict";
        if(!response.data.error){
            console.log(response);    
        }else{
            $scope.pageTitle = 'Fejl: ' + response.data.error;
        }
    });
});

app.controller('productViewControl', function ($scope) {
    
});

app.controller('searchViewControl', function ($scope) {
    
});

app.controller('footerControl', function ($scope, $http) {
    $http.get("./assets/lib/dataHandler.php?shopInfo")
    .then(function (response) {
        "use strict";
        if(!response.data.error){
            $scope.shopTitle = response.data.shopTitle;
            $scope.shopAddress = response.data.shopAddress;
            $scope.shopZipcode = response.data.shopZipcode;
            $scope.shopCity = response.data.shopCity;
            $scope.shopEmail = response.data.shopEmail;
            $scope.shopBae = response.data.shopBase;
            $scope.shopTelephone = response.data.shopTelephone;    
            //console.log(response);    
        }else{
            console.log('Fejl: ', response.data.error);
        }
    });
});

app.controller('randomProductControl', function ($scope, $http) {
    
});
