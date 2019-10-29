import Vote from '../components/Vote'
import UserInfo from '../components/UserInfo'
import MEditor from '../components/MEditor'
import highlight from './highlight'

export default {
    mixins: [highlight],
    components: {
        Vote,
        UserInfo,
        MEditor
    },
    data() {
        return {
            editing: false,
        }
    },
    methods: {
        edit() {
            this.setEditCache()
            this.editing = true
        },
        cancel() {
            this.restoreFromCache()
            this.editing = false
        },
        setEditCache() {},
        restoreFromCache() {},

        update() {
            axios.put(this.endpoint, this.payload())
            .catch(({response}) => {
                this.$toast.error(response.data.message, "Error", {
                    timeout: 3000
                })
            })
            .then(({data}) => {
                this.bodyHtml = data.body_html
                this.$toast.success(data.message, "Success", {
                    timeout: 3000
                })
                this.editing = false
            })
            .then(() => this.highlight())
        },
        payload() {},

        destroy() {
            this.$toast.question('정말 삭제하시겠어요?', "답글,", {
                timeout: 5000,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999,
                title: 'Hey',
                position: 'center',
                buttons: [
                    ['<button><b>네</b></button>', (instance, toast) => {

                        this.delete()

                        instance.hide({ transitionOut: 'flipOutX' }, toast, 'button');

                    }, true],
                    ['<button>아니요</button>', (instance, toast) => {
                        instance.hide({ transitionOut: 'fadeOutRight' }, toast, 'button');
                    }],
                ],
            });

        },

        delete() {}
    },
}
