<template>
    <div class="simple-title-table">
        <h3>
            {{ title }}
        </h3>
        <b-row>
            <b-input-group>
                <b-form-input
                    placeholder='Enter new name'
                    v-model="itemTitle"
                >
                </b-form-input>
                <b-input-group-append>
                    <b-button
                        size="sm"
                        text="Button"
                        variant="success"
                        @click="createItem"
                    >
                        Create
                    </b-button>
                </b-input-group-append>
            </b-input-group>
        </b-row>
        <div>
            <b-table
                :bordered="true"
                :borderless="false"
                :items="items"
            >
                <template #cell(id)="data">
                    {{ data.item.id }}
                </template>
                <template #cell(title)="data">
                    <b-input-group>
                        <b-form-input
                            v-model="data.item.title"
                            @change="changeTitle(data.item.id, data.item.title)"
                        >
                        </b-form-input>
                        <b-input-group-append>
                            <b-button
                                variant="outline-danger"
                                @click="deleteItem(data.item.id)"
                            >
                                Delete
                            </b-button>
                        </b-input-group-append>
                    </b-input-group>
                </template>

            </b-table>
        </div>
    </div>
</template>

<script>

export default {
    components: {
    },
    created() {
        this.updateTable();
    },
    data() {
        return {
            itemTitle: '',
            items: [],
        };
    },
    methods: {
        updateTable() {
            axios.get(this.url)
                .then(({ data }) => {
                    this.items = data.data;
                })
                .catch(() => {
                    this.items = [];
                });

        },
        createItem() {
            axios.post(this.url, {
                'title': this.itemTitle,
            })
            .then(({ data }) => {
                this.itemTitle = '';
                this.items.push(data.data);
            })
            .catch(() => {
                alert('Error!');
            });
        },
        deleteItem(itemId) {
            if (! confirm('Are you sure?')) {
                return;
            }

            axios.delete(this.url + '/' + itemId)
            .then(({ data }) => {
                for (let index = 0; index < this.items.length; index++) {
                    const element = this.items[index];

                    if (element.id != itemId) {
                        continue;
                    }

                    this.items.splice(index, 1);
                    break;
                }
            })
            .catch(() => {
                alert('Error!');
            });
        },
        changeTitle(itemId, title) {
            axios.patch(this.url + '/' + itemId, {
                'title': title,
            })
            .then(({ data }) => {})
            .catch(() => {
                alert('Error!');
            });
        },
    },
    watch: {
        currentPage: {
            handler: function(value) {
                this.updateTable(value);
            }
        },
    },
    props: {
        url: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
    }
};
</script>
