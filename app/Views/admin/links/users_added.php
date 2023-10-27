<?php $this->extend( 'admin/__layout/default' ) ?>


<?php $this->section('content') ?>

    <?php if(! empty($user)): ?>
        <div class="x_panel">
            <div class="x_content d-flex align-items-center justify-content-between">
                <h2>User : <b><?= esc( $user->username ) ?></b> </h2>
                <div>
                    <div class="form-group d-inline-block mr-3" >
                        <label class="control-label" for="first-name">Type :
                        </label>
                        <?= form_dropdown([
                            'class' => 'form-control d-inline w-auto',
                            'onchange' => 'users_added_links_type_change(this.value, '.$userId.')',
                            'options' => [
                                'stream' => 'stream',
                                'direct_dl' => 'direct_dl',
                                'torrent_dl' => 'torrent_dl'
                            ],
                            'selected' => $type ?? ''
                        ]) ?>
                    </div>

                    <a href="<?= admin_url('/users/edit/' . $user->id) ?>" class="btn btn-sm btn-secondary">Back to user</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="x_panel">
        <div>
            <div class="group-selection  d-none ve-results--filter" >
                <label class="control-label" for="first-name">Status:
                </label>
                <?= form_dropdown([
                    'name' => 'filter_links_results_by_type',
                    'class' => 'form-control',
                    'onchange' => 'users_added_links_custom_filter(this.value, null)',
                    'options' => [
                        'all' => 'All',
                        'active' => 'Approved',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected'
                    ],
                    'selected' => $status ?? ''
                ]) ?>
            </div>
            <div class="group-selection  d-none ve-results--filter" >
                <label class="control-label" for="first-name">Movie Type:
                </label>
                <?= form_dropdown([
                    'name' => 'filter_links_results_by_movie_type',
                    'class' => 'form-control',
                    'onchange' => 'users_added_links_custom_filter(null, this.value)',
                    'options' => [
                        'all' => 'All',
                        'movie' => 'Movies',
                        'episode' => 'TV Shows'
                    ],
                    'selected' => $movieType ?? ''
                ]) ?>
            </div>
        </div>
        <div class="card-box table-responsive">

            <table id="users-added-links-list-datatable" class="table text-center table-striped table-bordered data-list-table " style="width:100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Link</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>


                <tbody>


                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade " id="user-links-info-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">User's Link Approval</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                   <div class="d-flex justify-content-between">
                    
                       <div class="img-wrap">
                           <img src="#" class="movie-poster" width="155" alt="poster">
                       </div>
                       <ul class="list-group list-group-flush w-100 ml-3">
                           <li class="list-group-item">
                               <b>Title: </b>
                               <a href="#" target="_blank" class="movie-title"></a>
                                <span class="badge badge-dark float-right movie-type" style="font-size: 12px"></span>
                           </li>
                           <li class="list-group-item  sea-info">
                               <div class="d-flex align-items-center justify-content-between w-100">
                                   <div class="w-50">
                                       <b>Season: </b>
                                       <span class="badge bg-green season">1</span>
                                   </div>
                                   <div class="w-50">
                                       <b>Episode: </b>
                                       <span class="badge bg-green episode">1</span>
                                   </div>
                               </div>
                           </li>
                           <li class="list-group-item">
                               <b>Added by : </b>
                               <a href="#" class="added-user" target="_blank"></a>
                           </li>
                           <li class="list-group-item">
                               <div class="mb-1">
                                   <b>Link: </b>
                                   <span class="text-info font-weight-bold link-type">Stream</span>
                                   <a href="#" target="_blank" class="float-right text-dark user-link">
                                       <i class="fa fa-external-link"></i>&nbsp;
                                       Open link
                                   </a>
                               </div>
                               <textarea class="form-control user-link-view" id="" cols="30" rows="2" readonly></textarea>
                           </li>

                       </ul>
                   </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
                    <div>
                        <button type="button" class="btn reject-btn btn-danger" onclick="change_link_status(this, 0)" data-id="">
                            <i class="fa fa-close"></i>&nbsp;
                            Reject
                        </button>
                        <button type="button" class="btn approve-btn btn-success" onclick="change_link_status(this, 1)" data-id="">
                            <i class="fa fa-check"></i>&nbsp;
                            Approve
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php $this->endSection() ?>


<?php $this->section('scripts'); ?>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script>

        const LINKS_TYPE = '<?= $type ?>';
        const LINKS_STATUS = '<?= $status ?>';
        const LINKS_MOVIE_TYPE = '<?= $movieType ?>';
        const LINKS_USER_ID = '<?= $userId ?>';

        function change_link_status(elmt,  isApproved)
        {
            let btn = $(elmt);
            let linkId = btn.attr('data-id');
            btn.attr('disabled', 'disabled');
            let success = false;

            $.ajax({
                url : BASE_URL + '/links/update_status/' + linkId,
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest'},
                data: {
                    'is_approved' : isApproved
                },
                dataType: "JSON",
                async: false,
                success: function(data)
                {
                    if(data.success){
                        success = true;
                    }
                }
            });

            if(success){
                let elmtId = 'a[data-id="' + linkId + '"]';
                let row = $(elmtId).closest('tr');
                if(row){
                    let badge = null;
                    if(isApproved){
                        badge = '<span class="text-success status-val"> Active </span>';
                    }else{
                        badge = '<span class="text-danger status-val"> Rejected </span>';
                    }
                    row.find('.status-val').closest('td').html(badge);
                }

                if(isApproved){
                    alert('Link has been approved');
                }else{
                    alert('Link has been rejected');
                }
            }else{
                alert('something went wrong');
                btn.removeAttr('disabled');
            }

            $("#user-links-info-modal").modal('hide');
        }

        function show_user_link_info(elmt)
        {

            let $this = $(elmt);
            let linkId = $this.attr('data-id');

            // attempt to load movie info
            $.ajax({
                url : BASE_URL + '/links/load_link_info',
                type: "GET",
                headers: { 'X-Requested-With': 'XMLHttpRequest'},
                data: {
                    'link' : linkId
                },
                dataType: "JSON",
                async: false,
                success: function(data)
                {
                    if(data.success){

                        let infoModal = $("#user-links-info-modal");
                        data = data.data;

                        infoModal.find('.movie-poster').attr('src', data['poster']);
                        infoModal.find('.movie-title').text(data['title']);
                        infoModal.find('.movie-title').attr('href', data['movie_link']);
                        infoModal.find('.added-user').text(data['user']);
                        infoModal.find('.added-user').attr('href', data['user_link']);
                        infoModal.find('.link-type').text(data['type']);
                        infoModal.find('.user-link-view').val(data['link']);
                        infoModal.find('.user-link').attr('href', data['link']);
                        infoModal.find('.reject-btn, .approve-btn').attr('data-id', data['id']);

                        infoModal.find('.sea-info').hide();
                        infoModal.find('.movie-type').text('Movie');

                        if(data['movie_type'] === 'episode'){

                            infoModal.find('.sea-info').show();
                            infoModal.find('.season').text( data['season']);
                            infoModal.find('.episode').text( data['episode']);
                            infoModal.find('.movie-type').text('TV Show');

                        }

                        infoModal.find('.reject-btn, .approve-btn').removeAttr('disabled');
                        if(data['status'] === 'active'){
                            infoModal.find('.approve-btn').attr('disabled', 'disabled');
                        }

                        if(data['status'] === 'rejected'){
                            infoModal.find('.reject-btn').attr('disabled', 'disabled');
                        }

                        infoModal.modal('show');

                    }else{
                        alert('Info not found');
                    }
                }
            });

        }
    </script>

<?php $this->endSection(); ?>