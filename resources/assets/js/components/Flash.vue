<template>
    <div id="" class="alert alert-flash" :class="alertType" role="alert" v-show="show">
        {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message', 'type'],

        data() {
            return {
                body: '',
                show: false
            }
        },

        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message =>  {
                this.flash(message);
            });
        },

        methods: {
            flash(message) {
                this.body = message;
                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 10000);
            },
        },

        computed: {
            alertType() {
                let render = 'alert-';

                switch(this.type) {
                    case 'success':
                    case 'warning':
                    case 'danger':
                        render = render + this.type;
                        break;
                    default:
                        render = render + 'info';
                }

                return render;
            }
        },
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        right: 10px;
        top: 10px;
    }
</style>
