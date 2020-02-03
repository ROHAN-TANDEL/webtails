# webtails
code igniter - with controller dependency inject - custom added feature

##front controller - display list of students
###http://localhost:81/webtails/viewsController/ListViewController

##internal view to controller api call:
##to delete the api
###http://localhost:81/webtails/viewsController/ListViewController/delete/9

##list of active students using limit and skip cursor
###http://localhost:81/webtails/index.php/students/StudentSubjectMarksMappingController/listMapCursor/{limit}/{skip}

##update the api with marks additing else creates a new entry on valid student && subject
###http://localhost:81/webtails/index.php/students/StudentSubjectMarksMappingController/UpdateOrCreateMap/{name}/{subject}/{marks}

##get speicific user mapping with subject and marks
###http://localhost:81/webtails/index.php/students/StudentSubjectMarksMappingController/specificMapById/1

##get list of deleted students
###http://localhost:81/webtails/index.php/students/StudentSubjectMarksMappingController/deletedList

##delete user mapping by id
###http://localhost:81/webtails/index.php/students/StudentSubjectMarksMappingController/deleteMapById/{id}
