<template>
    <div class="employee">
        <h2>
            {{ employeeName }}
        </h2>
        <b-row>
            <b-col>
                <b-form-group label="Post">
                    <b-form-select
                        v-model="postId"
                        :options="posts"
                        @change="postChange"
                    >
                    </b-form-select>
                </b-form-group>
            </b-col>
            <b-col>
                <b-form-group label="Skills">
                    <b-form-checkbox-group
                        v-model="selectedSkills"
                        :options="skills"
                        @change="skillsChange"
                        switches
                    >
                    </b-form-checkbox-group>
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>

<script>

export default {
    created() {
        this.updatePosts();
        this.updateSkills();
        this.updateEmployee();
    },
    data() {
        return {
            posts: [],
            skills: [],
            employee: {},
            employeeName: '',
            postId: null,
            selectedSkills: [],
        };
    },
    methods: {
        updateEmployee() {
            axios.get('/employee/' + this.id)
                .then(({ data }) => {
                    console.log(data);
                    this.employee = data.data;
                    this.employeeName = this.employee.user.name;

                    this.postId = this.employee.post ? this.employee.post.id : null;

                    this.employee.skills.forEach(employeeSkill => {
                        this.selectedSkills.push(employeeSkill.skill_id);
                    });
                })
                .catch(() => {
                    alert('Error!');
                });
        },
        updatePosts() {
            this.posts = [
                { value: null, text: 'Please select an post' },
            ];

            axios.get('/post')
                .then(({ data }) => {
                    data.data.forEach(element => {
                        this.posts.push(
                            { value: element.id, text: element.title },
                        );
                    });
                })
                .catch(() => {
                    alert('Error!');
                });
        },
        updateSkills() {
            axios.get('/skill')
                .then(({ data }) => {
                    data.data.forEach(element => {
                        this.skills.push(
                            { value: element.id, text: element.title },
                        );
                    });
                })
                .catch(() => {
                    alert('Error!');
                });
        },
        postChange() {
            axios.patch(`/employee-post/${this.id}/update/${this.postId}`)
                .then(({ data }) => {})
                .catch(() => {
                    alert('Error!');
                });

        },
        skillsChange() {
            axios.patch(`/employee-skills/${this.id}/update`, {
                'skill_ids': this.selectedSkills,
            })
            .then(({ data }) => {})
            .catch(() => {
                alert('Error!');
            });
        }

    },
    props: {
        id: {
            required: true
        },
    }
};
</script>
