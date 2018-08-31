<template>
    <div class="container">
        <div class="user-reviews-container">
            <div class="user-reviews-header">
                <h3 class="subtitle is-4">users recent reviews</h3>
                <div class="header-btn">
                    <a class="button is-info">
                        <span>See all 60 reviews</span>
                    </a>
                </div>
            </div>


            <ul class="columns is-variable is-4 is-multiline user-reviews-items">
                <li class="column is-4">
                    <div class="user-reviews-item">

                        <div class="card-image">
                            <figure class="image is-3by1">
                                <img src="https://igx.4sqi.net/img/general/340x170/139800814_QQO75Sr4LRtolXbmuOvmXPSz2HiFFmOTKeiMuJgumVs.jpg"
                                     alt="Placeholder image">
                            </figure>
                            <div class="user-review-save">
                                <a class="button ">
                                  <span class="icon">
                                      <i class="far fa-bookmark"></i>
                                    </span>
                                    <span>Save</span>
                                </a>
                            </div>
                        </div>
                        <div class="user-review-content">
                            "Пиво есть интересное, но кухня плохая. Вредом приду сюда 2й раз"
                        </div>
                        <div class="user-review-tip">
                            <a class="user-tip-image" href="/user/4">
                                <img class="image is-32x32"
                                     src="https://www.microsoft.com/en-us/research/uploads/prod/2018/02/ProfilePhoto.jpg"
                                     alt="">
                            </a>
                            <span class="user-tip-name">
                                <a href="/user/4">
                                    Alex Fiannaca
                                </a>
                        </span>
                            <span class="user-tip-date">
                            <a href="/user/4">
                                Декабрь 30, 2017
                            </a>
                        </span>
                        </div>
                        <div class="user-review-place">
                            <div class="user-review-name">
                                <a class="review-place-link" href="#">
                                    Patio Pasterio
                                </a>
                                <span class="review-place-name">
                                Italian Restoraunt
                            </span>
                                <span class="review-place-city">
                                Odesa
                            </span>
                            </div>
                            <div class="media">
                                <div class="media-right rating-wrapper">
                                    <PlaceRating
                                            :value="Number(10)"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="column is-4">
                    <div class="user-reviews-item">

                        <div class="card-image">
                            <figure class="image is-3by1">
                                <img src="https://igx.4sqi.net/img/general/340x170/139800814_QQO75Sr4LRtolXbmuOvmXPSz2HiFFmOTKeiMuJgumVs.jpg"
                                     alt="Placeholder image">
                            </figure>
                            <div class="user-review-save">
                                <a class="button ">
                                  <span class="icon">
                                      <i class="far fa-bookmark"></i>
                                    </span>
                                    <span>Save</span>
                                </a>
                            </div>
                        </div>
                        <div class="user-review-content">
                            "Пиво есть интересное, но кухня плохая. Вредом приду сюда 2й раз"
                        </div>
                        <div class="user-review-tip">
                            <a class="user-tip-image" href="/user/4">
                                <img class="image is-32x32"
                                     src="https://www.microsoft.com/en-us/research/uploads/prod/2018/02/ProfilePhoto.jpg"
                                     alt="">
                            </a>
                            <span class="user-tip-name">
                                <a href="/user/4">
                                    Alex Fiannaca
                                </a>
                        </span>
                            <span class="user-tip-date">
                            <a href="/user/4">
                                Декабрь 30, 2017
                            </a>
                        </span>
                        </div>
                        <div class="user-review-place">
                            <div class="user-review-name">
                                <a class="review-place-link" href="#">
                                    Patio Pasterio
                                </a>
                                <span class="review-place-name">
                                Italian Restoraunt
                            </span>
                                <span class="review-place-city">
                                Odesa
                            </span>
                            </div>
                            <div class="media">
                                <div class="media-right rating-wrapper">
                                    <PlaceRating
                                            :value="Number(10)"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="column is-4">
                    <div class="user-reviews-item">

                        <div class="card-image">
                            <figure class="image is-3by1">
                                <img src="https://igx.4sqi.net/img/general/340x170/139800814_QQO75Sr4LRtolXbmuOvmXPSz2HiFFmOTKeiMuJgumVs.jpg"
                                     alt="Placeholder image">
                            </figure>
                            <div class="user-review-save">
                                <a class="button ">
                                  <span class="icon">
                                      <i class="far fa-bookmark"></i>
                                    </span>
                                    <span>Save</span>
                                </a>
                            </div>
                        </div>
                        <div class="user-review-content">
                            "Пиво есть интересное, но кухня плохая. Вредом приду сюда 2й раз"
                        </div>
                        <div class="user-review-tip">
                            <a class="user-tip-image" href="/user/4">
                                <img class="image is-32x32"
                                     src="https://www.microsoft.com/en-us/research/uploads/prod/2018/02/ProfilePhoto.jpg"
                                     alt="">
                            </a>
                            <span class="user-tip-name">
                                <a href="/user/4">
                                    Alex Fiannaca
                                </a>
                        </span>
                            <span class="user-tip-date">
                            <a href="/user/4">
                                Декабрь 30, 2017
                            </a>
                        </span>
                        </div>
                        <div class="user-review-place">
                            <div class="user-review-name">
                                <a class="review-place-link" href="#">
                                    Patio Pasterio
                                </a>
                                <span class="review-place-name">
                                Italian Restoraunt
                            </span>
                                <span class="review-place-city">
                                Odesa
                            </span>
                            </div>
                            <div class="media">
                                <div class="media-right rating-wrapper">
                                    <PlaceRating
                                            :value="Number(10)"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="column is-4">
                    <div class="user-reviews-item">

                        <div class="card-image">
                            <figure class="image is-3by1">
                                <img src="https://igx.4sqi.net/img/general/340x170/139800814_QQO75Sr4LRtolXbmuOvmXPSz2HiFFmOTKeiMuJgumVs.jpg"
                                     alt="Placeholder image">
                            </figure>
                            <div class="user-review-save">
                                <a class="button ">
                                  <span class="icon">
                                      <i class="far fa-bookmark"></i>
                                    </span>
                                    <span>Save</span>
                                </a>
                            </div>
                        </div>
                        <div class="user-review-content">
                            "Пиво есть интересное, но кухня плохая. Вредом приду сюда 2й раз"
                        </div>
                        <div class="user-review-tip">
                            <a class="user-tip-image" href="/user/4">
                                <img class="image is-32x32"
                                     src="https://www.microsoft.com/en-us/research/uploads/prod/2018/02/ProfilePhoto.jpg"
                                     alt="">
                            </a>
                            <span class="user-tip-name">
                                <a href="/user/4">
                                    Alex Fiannaca
                                </a>
                        </span>
                            <span class="user-tip-date">
                            <a href="/user/4">
                                Декабрь 30, 2017
                            </a>
                        </span>
                        </div>
                        <div class="user-review-place">
                            <div class="user-review-name">
                                <a class="review-place-link" href="#">
                                    Patio Pasterio
                                </a>
                                <span class="review-place-name">
                                Italian Restoraunt
                            </span>
                                <span class="review-place-city">
                                Odesa
                            </span>
                            </div>
                            <div class="media">
                                <div class="media-right rating-wrapper">
                                    <PlaceRating
                                            :value="Number(10)"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="column is-4">
                    <div class="user-reviews-item">

                        <div class="card-image">
                            <figure class="image is-3by1">
                                <img src="https://igx.4sqi.net/img/general/340x170/139800814_QQO75Sr4LRtolXbmuOvmXPSz2HiFFmOTKeiMuJgumVs.jpg"
                                     alt="Placeholder image">
                            </figure>
                            <div class="user-review-save">
                                <a class="button ">
                                  <span class="icon">
                                      <i class="far fa-bookmark"></i>
                                    </span>
                                    <span>Save</span>
                                </a>
                            </div>
                        </div>
                        <div class="user-review-content">
                            "Пиво есть интересное, но кухня плохая. Вредом приду сюда 2й раз"
                        </div>
                        <div class="user-review-tip">
                            <a class="user-tip-image" href="/user/4">
                                <img class="image is-32x32"
                                     src="https://www.microsoft.com/en-us/research/uploads/prod/2018/02/ProfilePhoto.jpg"
                                     alt="">
                            </a>
                            <span class="user-tip-name">
                                <a href="/user/4">
                                    Alex Fiannaca
                                </a>
                        </span>
                            <span class="user-tip-date">
                            <a href="/user/4">
                                Декабрь 30, 2017
                            </a>
                        </span>
                        </div>
                        <div class="user-review-place">
                            <div class="user-review-name">
                                <a class="review-place-link" href="#">
                                    Patio Pasterio
                                </a>
                                <span class="review-place-name">
                                Italian Restoraunt
                            </span>
                                <span class="review-place-city">
                                Odesa
                            </span>
                            </div>
                            <div class="media">
                                <div class="media-right rating-wrapper">
                                    <PlaceRating
                                            :value="Number(10)"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {mapState, mapActions, mapGetters} from 'vuex';
    import PlaceRating from '@/components/place/PlaceRating';

    export default {
        name: 'GeneralInfo',
        data() {
            return {};
        },
        components: {
            PlaceRating,
        },
    };
</script>

<style lang="scss" scoped>

    .user-reviews-container {
        margin-top: 60px;

        .user-reviews-header {
            display: flex;
            justify-content: space-between;
            @media screen and (max-width: 768px) {
                text-align: center;
                flex-direction: column;
                margin-bottom: 20px;
            }
        }

        .header-btn {
            a {
                width: 300px;
            }
            span {
                font-size: 18px;
                padding: 0 30px;
                font-weight: normal;
            }
        }
    }

    .user-reviews {
        margin: 20px 0;
    }

    .user-reviews-item {
        background-color: #fff;
        align-items: center;

        .card-image {
            position: relative;

            .user-review-save {
                display: inline-block;
                position: absolute;
                top: 10px;
                right: 15px;

                span {
                    color: #56565C;
                }

                i {
                    color: #e3e3e8;
                    transition: 0.2s linear;
                }

                &:hover {
                    i {
                        color: #56565C;
                    }
                }
            }
        }

        .user-review-content {
            padding: 20px;
            height: 153px;
            font-size: 17px;
            line-height: 26px;
            font-weight: 300;
            word-wrap: break-word;
        }

        .user-review-tip {
            padding: 0 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #efeff4;
            height: 40px;

            .user-tip-image {
                margin-right: 10px;
                img {
                    vertical-align: middle;
                }
            }

            .user-tip-name,
            .user-tip-date {
                margin-right: 10px;
                a {
                    color: #aeb4b6;
                    font-size: 12px;
                    &:hover {
                        text-decoration: underline;
                    }
                }
            }

            .user-tip-date {
                margin-right: 0;
            }

        }

        .user-review-place {
            padding: 0 20px;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;

            .user-review-name {

                .review-place-link {
                    display: block;
                    color: #5656ce;

                    &:hover {
                        text-decoration: underline;
                    }
                }

                .review-place-name,
                .review-place-city {
                    font-size: 12px;
                    color: #aeb4b6;
                }

                .review-place-city::before {
                    content: '';
                    display: inline-block;
                    width: 2px;
                    height: 2px;
                    background-color: #aeb4b6;
                    vertical-align: middle;
                    margin-bottom: 2px;
                }

            }

            .rating-wrapper {
                .rating {
                    padding: 0 5px;
                    line-height: 28px;
                    font-size: 14px;
                    font-weight: bold;
                }

            }
        }
    }
</style>