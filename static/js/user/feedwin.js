if(feedObj) { 
    const url = new URL(location.href);
    feedObj.iuser = parseInt(url.searchParams.get('iuser'));
    feedObj.getFeedUrl = '/user/feed';
    feedObj.getFeedList();
}

(function() {
    const spanCntFollower = document.querySelector('#spanCntFollower');
    const lData = document.querySelector('#lData');
    const btnFollow = document.querySelector('#btnFollow');
    const btnDelCurrentProfilePic = document.querySelector('#btnDelCurrentProfilePic');
    const btnProfileImgModalClose = document.querySelector('#btnProfileImgModalClose');

    if(btnFollow) {
        btnFollow.addEventListener('click', function() {
            const param = {
                toiuser: parseInt(lData.dataset.toiuser)
            };
            console.log(param);
            const follow = btnFollow.dataset.follow;
            console.log('follow : ' + follow);
            const followUrl = '/user/follow';
            switch(follow) {
                case '1': //팔로우 취소
                    fetch(followUrl + encodeQueryString(param), {method: 'DELETE'})
                    .then(res => res.json())
                    .then(res => {                        
                        if(res.result) {
                            //팔로워 숫자 변경
                            const cntFollowerVal = parseInt(spanCntFollower.innerText);
                            spanCntFollower.innerText = cntFollowerVal - 1;

                            btnFollow.dataset.follow = '0';
                            btnFollow.classList.remove('btn-outline-secondary');
                            btnFollow.classList.add('btn-primary');
                            if(btnFollow.dataset.youme === '1') {
                                btnFollow.innerText = '맞팔로우 하기';
                            } else {
                                btnFollow.innerText = '팔로우';
                            }                            
                        }
                    });
                    break;
                case '0': //팔로우 등록
                    fetch(followUrl, {
                        method: 'POST',
                        body: JSON.stringify(param)
                    })
                    .then(res => res.json())
                    .then(res => {
                        if(res.result) {
                            //팔로워 숫자 변경
                            const cntFollowerVal = parseInt(spanCntFollower.innerText);
                            spanCntFollower.innerText = cntFollowerVal + 1;

                            btnFollow.dataset.follow = '1';
                            btnFollow.classList.remove('btn-primary');
                            btnFollow.classList.add('btn-outline-secondary');
                            btnFollow.innerText = '팔로우 취소';
                        }
                    });
                    break;
            }
        });
    }
    //프로필 사진 삭제
    if(btnDelCurrentProfilePic){
        btnDelCurrentProfilePic.addEventListener('click', e=>{
            //기존 프로필 이미지를 디폴트로 변경
            const profileImgList = document.querySelectorAll('.profileimg');
                    profileImgList.forEach(item => {
                        item.src = '/static/img/profile/defaultProfileImg_100.png';
                    })
            //usermodel profile함수와 통신
            fetch('/user/profile', { method: 'DELETE'})
            .then(res => res.json)
            .then(res => {
                if(res.result){
                }
                btnProfileImgModalClose.click();
            })
        })
    }
})();


//프로필 이미지 수정
(function() {
    if(btnProfileMod) {
        const profileModal = document.querySelector('#upload');
        const profileElem = profileModal.querySelector('form');
        const profileBtnClose = document.querySelector('#btnProfileImgModalClose');

        //사진 업로드 버튼 선택
        const btnProfileMod = document.querySelector('#btnProfileMod');
        //사진 업로드 버튼을 눌렀을때 이벤트
        btnProfileMod.addEventListener('click', function() {
        profileElem.imgs.click();
        });
        //작동 확인 완료
        
        
        //이미지 값이 변하면
        profileElem.imgs.addEventListener('change', function(e) {
            console.log(`length: ${e.target.files.length}`);
            const profileImgList = document.querySelectorAll('.profileimg');
            
            if(e.target.files.length > 0) {
                const profileImgSource = e.target.files[0];

                const profileReader = new FileReader(); // 파일리더 객체 호출
                profileReader.readAsDataURL(profileImgSource); //바이너리 파일을 Base64 Encode 문자열로 반환
                profileReader.onload = function(){ //	읽기 동작이 성공적으로 완료되었을 때, 함수 실행
                    //화면상에 보이는 프로필 사진들을 변경
                    profileImgList.forEach((profileImg) => {
                        profileImg.src = profileReader.result;
                    });
                }
                //선택한 파일의 파일명 추출
                const files = profileElem.imgs.files;

                const pData = new FormData();
                
                pData.append('imgs', files[0]);
                console.log(`pData : ${pData.imgs}`);
                
                fetch('/user/profile', {
                    method: 'post',
                    body: pData})
                    .then(res => res.json())
                    .then(myJson => {
                    console.log(myJson);
                    if(myJson) {                                
                    }
                    profileBtnClose.click();
                    });
            }
        }); 
        
        //사진 업로드를 눌렀을때
        
    }

    

})();