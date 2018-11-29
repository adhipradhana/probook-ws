var app = angular.module("probookSearch", []); 

app.controller("searchBook", function($scope, $http) {
    $scope.books = [];
    $scope.status = false;
    $scope.search = function () {
        var search_query = encodeURI($scope.query);
        document.getElementById('loader').classList.add('visible');
        $http({
            url: "/soapsearch", 
            method: "GET",
            params: {query: search_query}
        }).then(function(response) {
            //First function handles success
            document.getElementById('loader').classList.remove('visible');
            console.log(response.data);
            $scope.books = response.data;
            console.log($scope.books);
            $scope.status = true;
        }, function(response) {
            document.getElementById('loader').classList.remove('visible');
            console.log("error");
        });
    }
});
