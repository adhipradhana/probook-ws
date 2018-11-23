var app = angular.module("probookSearch", []); 

app.controller("searchBook", function($scope) {
    $scope.books = [];
    $scope.status = false;
    $scope.search = function () {
        console.log("NIGGA");
        $scope.status = true;
        $scope.books = [
            {
                id: 1,
                title: 'The Communist Manifesto',
                author: 'Karl Marx',
                synopsis: 'The Communist Manifesto is divided into a preamble and four sections, the last of these a short conclusion.',
                rating: 0,
                vote: 0   
            },
            {
                id: 2,
                title: 'The Cold War: A New History',
                author: 'John Lewis Gaddis',
                synopsis: 'The dean of Cold War historians (The New York Times) now presents the definitive account of the global confrontation that dominated the last half of the twentieth century.',
                rating: 0,
                vote: 0  
            }
        ]
        setInterval(function() {
            console.log("ANJINGGG");
            $scope.$apply() 
        }, 1000);
    } 
});