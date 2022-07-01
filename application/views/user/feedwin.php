<div class="d-flex flex-column align-items-center">
    <div class="size_box_100"></div>
    <div class="w100p_mw614">
        <div class="d-flex flex-row">
            <div class="d-flex flex-column justify-content-center">
                <div class="circleimg h150 w150 pointer" feedwin id="btnNewFeedModal" data-bs-toggle="modal" data-bs-target="#newProfileModal">
                    <!--data-bs-target:모달창으로 열 타겟-->
                    <img src='/static/img/profile/<?= $this->data->iuser ?>/<?= $this->data->mainimg ?>' onerror='this.error=null;this.src="/static/img/profile/defaultProfileImg_100.png"'>

                    <div> <?php print $this->data->iuser ?> </div>
                </div>
            </div>

            <div></div>
            <!--프로필 이미지 변경 모달-->
            <div class="modal fade t-center" id="newProfileModal" tabindex="-1" aria-labelledby="newFeedModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content" id="newFeedModalContent">
                        <div class="modal-header justify-content-center" id="modal-header">
                            <h5 class="modal-title p-3" id="newFeedModalLabel f-bold">프로필 사진바꾸기</h5>
                        </div>
                        <div class="modal-body d-flex flex-column justify-content-center" id="modal-body">
                            <h6 class="f-blue _modal_item">사진 업로드</h6>
                            <hr>
                            <h6 class="f-red _modal_item">현재 사진 삭제</h6>
                            <hr>
                            <h6 class="pointer _modal_item" data-bs-dismiss="modal" aria-label="close">취소</h6>
                        </div>
                    </div>
                    <form class="d-none">
                        <input type="file" accept="image/*" name="imgs" multiple>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>