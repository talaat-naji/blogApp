class services{

   async getPosts() {
      let response = await fetch('/feedss');
       return response.json();
   }
    
   async likePosts(postId) {
    let jsonBody = JSON.stringify({'postId':postId});
       
       // let response = 
        await fetch('/del', {
            method: 'POST',
            body: jsonBody,
            headers: {
                'Content-Type': 'application/json'
            }
        });
  }
}
service = new services();
root = document.getElementsByClassName('acts');
let n = 0;
while(n<root.length){
    like = document.createElement('button');
    like.className = "btn btn";
like.innerText = "Like";
         
like.addEventListener('click', (event) => {
    console.log('like clicked for post', n);
            });
    root[n].append(like);
    comment = document.createElement('button');
    comment.className = "btn btn";
    comment.innerText = "comment";
             
    comment.addEventListener('click', (event) => {
                    service.commentPost();
                });
        root[n].append(comment);
    n++;
}






// root = document.getElementById('acts');

// async function showPostv() {
//    let res = await service.getPosts();
//     console.log(res);
//     res.forEach((element) => {
//         blog_text = document.createElement('p');
// blog_img = document.createElement('img');
// blog_img.alt = "here image will be display";
// blog_img.setAttribute('width','600px');
//         blog_img.setAttribute('height', '500px');
        
//         blog_text.innerText = element.blog_text;
//         blog_img.src = element.pic_path;

//         like = document.createElement('button');
//         like.innerText = "Like";
//         comment = document.createElement('button');
//         comment.innerText = "comment";

//         like.addEventListener('click', (event) => {
//             service.likePost();
//         });
//         del.addEventListener('click', (event) => {
//             service.delPost();
//         })
//         root.append(blog_text, blog_img, like, comment);
//     });
// }
// showPostv();
