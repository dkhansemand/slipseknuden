var app = angular.module('slipseknuden', ['ngRoute']);

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
    .when('/Produkter', {
        controller: 'productControl',
        templateUrl : './assets/views/products.html'
    })
    .when('/Produkt/:ID', {
        controller: 'productViewControl',
        templateUrl : './assets/views/productView.html'
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

app.controller('homeControl', function ($scope) {
    
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

app.controller('productsControl', function ($scope) {
    
});

app.controller('productViewControl', function ($scope) {
    
});

app.controller('footerControl', function ($scope) {
    
});