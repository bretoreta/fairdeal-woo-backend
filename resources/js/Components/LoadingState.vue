<template>
    <div class="h-56 w-full flex items-center justify-center">
        <div class="cube-wrapper">
            <div class="cube-folding">
                <span class="leaf1"></span>
                <span class="leaf2"></span>
                <span class="leaf3"></span>
                <span class="leaf4"></span>
            </div>
        </div>
    </div>
</template>
<style scoped>
.cube-folding {
  width: 50px;
  height: 50px;
  display: inline-block;
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  transform: rotate(45deg);
  font-size: 0;
}
.cube-folding span {
  position: relative;
  width: 25px;
  height: 25px;
  -webkit-transform: scale(1.1);
  -moz-transform: scale(1.1);
  transform: scale(1.1);
  display: inline-block;
}
.cube-folding span::before {
  content: "";
  background-color: #04f568;
  position: absolute;
  left: 0;
  top: 0;
  display: block;
  width: 25px;
  height: 25px;
  -moz-transform-origin: 100% 100%;
  -ms-transform-origin: 100% 100%;
  -webkit-transform-origin: 100% 100%;
  transform-origin: 100% 100%;
  -webkit-animation: folding 2.5s infinite linear both;
  -moz-animation: folding 2.5s infinite linear both;
  animation: folding 2.5s infinite linear both;
}
.cube-folding .leaf2 {
  -webkit-transform: rotateZ(90deg) scale(1.1);
  -moz-transform: rotateZ(90deg) scale(1.1);
  transform: rotateZ(90deg) scale(1.1);
}
.cube-folding .leaf2::before {
  -webkit-animation-delay: 0.3s;
  animation-delay: 0.3s;
  background-color: #e6e6e6;
}
.cube-folding .leaf3 {
  -webkit-transform: rotateZ(270deg) scale(1.1);
  -moz-transform: rotateZ(270deg) scale(1.1);
  transform: rotateZ(270deg) scale(1.1);
}
.cube-folding .leaf3::before {
  -webkit-animation-delay: 0.9s;
  animation-delay: 0.9s;
  background-color: #f2f2f2;
}
.cube-folding .leaf4 {
  -webkit-transform: rotateZ(180deg) scale(1.1);
  -moz-transform: rotateZ(180deg) scale(1.1);
  transform: rotateZ(180deg) scale(1.1);
}
.cube-folding .leaf4::before {
  -webkit-animation-delay: 0.6s;
  animation-delay: 0.6s;
  background-color: #00A74C;
}

@-webkit-keyframes folding {
  0%, 10% {
    -webkit-transform: perspective(140px) rotateX(-180deg);
    -moz-transform: perspective(140px) rotateX(-180deg);
    transform: perspective(140px) rotateX(-180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
  25%, 75% {
    -webkit-transform: perspective(140px) rotateX(0deg);
    -moz-transform: perspective(140px) rotateX(0deg);
    transform: perspective(140px) rotateX(0deg);
    -webkit-opacity: 1;
    -moz-opacity: 1;
    opacity: 1;
  }
  90%, 100% {
    -webkit-transform: perspective(140px) rotateY(180deg);
    -moz-transform: perspective(140px) rotateY(180deg);
    transform: perspective(140px) rotateY(180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
}
@-moz-keyframes folding {
  0%, 10% {
    -webkit-transform: perspective(140px) rotateX(-180deg);
    -moz-transform: perspective(140px) rotateX(-180deg);
    transform: perspective(140px) rotateX(-180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
  25%, 75% {
    -webkit-transform: perspective(140px) rotateX(0deg);
    -moz-transform: perspective(140px) rotateX(0deg);
    transform: perspective(140px) rotateX(0deg);
    -webkit-opacity: 1;
    -moz-opacity: 1;
    opacity: 1;
  }
  90%, 100% {
    -webkit-transform: perspective(140px) rotateY(180deg);
    -moz-transform: perspective(140px) rotateY(180deg);
    transform: perspective(140px) rotateY(180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
}
@-ms-keyframes folding {
  0%, 10% {
    -webkit-transform: perspective(140px) rotateX(-180deg);
    -moz-transform: perspective(140px) rotateX(-180deg);
    transform: perspective(140px) rotateX(-180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
  25%, 75% {
    -webkit-transform: perspective(140px) rotateX(0deg);
    -moz-transform: perspective(140px) rotateX(0deg);
    transform: perspective(140px) rotateX(0deg);
    -webkit-opacity: 1;
    -moz-opacity: 1;
    opacity: 1;
  }
  90%, 100% {
    -webkit-transform: perspective(140px) rotateY(180deg);
    -moz-transform: perspective(140px) rotateY(180deg);
    transform: perspective(140px) rotateY(180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
}
@keyframes folding {
  0%, 10% {
    -webkit-transform: perspective(140px) rotateX(-180deg);
    -moz-transform: perspective(140px) rotateX(-180deg);
    transform: perspective(140px) rotateX(-180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
  25%, 75% {
    -webkit-transform: perspective(140px) rotateX(0deg);
    -moz-transform: perspective(140px) rotateX(0deg);
    transform: perspective(140px) rotateX(0deg);
    -webkit-opacity: 1;
    -moz-opacity: 1;
    opacity: 1;
  }
  90%, 100% {
    -webkit-transform: perspective(140px) rotateY(180deg);
    -moz-transform: perspective(140px) rotateY(180deg);
    transform: perspective(140px) rotateY(180deg);
    -webkit-opacity: 0;
    -moz-opacity: 0;
    opacity: 0;
  }
}
.cube-wrapper {
  width: 100px;
  height: 100px;
  text-align: center;
}
</style>