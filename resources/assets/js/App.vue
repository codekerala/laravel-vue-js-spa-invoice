<template>
    <div class="container">
        <div class="navbar">&nbsp;</div>
        <div class="content">
            <transition name="fade" mode="out-in">
                <router-view class="page" :key="$route.path"></router-view>
            </transition>
        </div>
    </div>
</template>
