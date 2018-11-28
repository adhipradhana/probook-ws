var app = angular.module("probookSearch", []); 

app.controller("searchBook", function($scope, $http) {
    $scope.books = [];
    $scope.status = false;
    $scope.search = function () {
        var search_query = encodeURI($scope.query);
        $http({
            url: "/soapsearch", 
            method: "GET",
            params: {query: search_query}
        }).then(function(response) {
            //First function handles success
            console.log(response.data);
            $scope.books = response.data;
            $scope.status = true;
        }, function(response) {
            console.log("error");
        });
    }
});
