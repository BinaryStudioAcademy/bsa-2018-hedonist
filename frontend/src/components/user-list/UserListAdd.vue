<template>
    <div class="container">
        <div class="left-block">
            <div class="list-edit-details">
                <div class="name-desc-section">
                    <input type="text" class="text">
                </div>
                <div class="photo-section">
                    <div>
                        <img class="list-page-image" src="" alt="">
                    </div>
                    <div class="selector-button flatButton">Photo ▾</div>
                </div>
                <div class="buttons">
                    <button class="button-green">Save</button>
                    <span class="button-link">Cancel</span>
                </div>
            </div>
            <div class="search-places">
                <input type="text" class="">
            </div>
        </div>
        <div class="right-block">2</div>
    </div>
</template>

<script>
    export default {
        name: "UserListAdd",
        data: function () {
            return [

            ]
        }
    }
</script>

<style lang="scss" scoped>
    .container {
        border-radius: 3px;
        background: #fff;
        position: relative;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-areas: "left left right";
    }

    .left-block {
        grid-area: left;
        display: flex;
        flex-direction: column;

        .list-edit-details {
            padding: 20px;
            display: flex;
            flex-direction: column;

            .photo-section {
                height: 118px;
                width: 118px;
                position: relative;

                border-radius: 3px;
                background: #f5f5f5 url(../../assets/no-photo.png) no-repeat center 40px;
                background-position: center 25px;
            }

            .selector-button {
                bottom: 0;
                margin: 11px;
                width: 96px;
                position: absolute;

                border-radius: 3px;
                background: #4d4d4d;
                background: rgba(0,0,0,0.2);
                color: #fff;
                cursor: pointer;
                font: bold 11px/30px "Helvetica Neue",Helvetica,Arial,sans-serif;
                line-height: 20px;
                text-align: center;
                text-transform: uppercase;
            }

            .buttons {
                margin-top: 10px;
            }
        }

        .search-places {
            background: #f0f4f5;
            border-bottom: 1px solid #dae4e6;
            border-top: 1px solid #dae4e6;
            overflow: hidden;
            padding: 20px;
        }
    }

    .right-block {
        grid-area: right;
    }

    .text {
        font-size: 2rem;
        font-weight: bold;
        line-height: 120%;
        padding: 6px 7px 5px 5px;

        transition-duration: .33s;
        transition-property: background,border,color,opacity,box-shadow;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        color: #4e595d;
        letter-spacing: 0;
        -webkit-font-smoothing: antialiased;
        background: #fff;
        border: 1px solid #c7cdcf;
        outline: none;
        margin: 0 0 10px 0;
        width: 450px;
    }

    .button-green {
        letter-spacing: 0;
        box-sizing: border-box;
        box-shadow: none;
        text-shadow: none;
        border-radius: 3px;
        background: #00b551;
        border: 1px solid rgba(0,0,0,0.05);
        color: #fff;
        cursor: pointer;
        display: block;
        font-size: 0.9rem;
        height: 30px;
        line-height: 28px;
        padding: 0 30px;
        text-align: center;
        text-transform: none;
        margin-right: 15px;
    }

    .button-link {
        color: #2d5be3;
        cursor: pointer;
        font-size: 0.9rem;
    }




</style>