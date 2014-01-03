function get_record_id(record_id) {
     var p = {};
     p[record_id] = record_id
     $('#content').load(/main/ros_judge,p,function(str){

     });

}