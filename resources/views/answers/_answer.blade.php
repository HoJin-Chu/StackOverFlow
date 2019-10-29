<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        <vote :model="{{ $answer }}" name="answer"></vote>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea class="form-control" v-model="body" rows="10" placeholder="10자 이상 작성해야합니다" required></textarea>
                </div>
                <button class="btn btn-primary" :disabled="isInvalid">수정</button>
                <button class="btn btn-outline-secondary"
                @click="cancel" type="button"
                >취소</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can('update', $answer)
                                <a @click.prevent="edit" class="btn btn-sm btn-outline-info">수정</a>
                            @endcan

                            @can('delete', $answer)
                            <button @click="destroy" class="btn btn-sm btn-outline-danger">삭제</button>

                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info
                        :model = "{{ $answer }}"
                        label = "Answered"
                        ></user-info>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>
