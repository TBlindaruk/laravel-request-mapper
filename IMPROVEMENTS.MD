# FIRST

## Problem

Good idea, but when your application has Application(Service) layer extracted from Http part you want to remove all HTTP-specific information from classes, which envolved there. DTO's are, but they have some HTTP specific info: "Your DTO object should extend one of RequestData classes:"

I usually make getDto() method in my Laravel FormRequest classes, which returns pure DTO.

## Solution

1. Try to add the configuration of the DTO strategy like the route parameter binding (https://laravel.com/docs/5.7/routing#route-model-binding). So, after this manipulation we will be able to have only one of the DTO object - RequestData.

2. Delete Request Data class, push data to the DTO via reflection....
