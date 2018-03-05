(function(){
mobileImgScroll=function(){};
mobileImgScroll.prototype={
	/*初始化对象*/
	init:function(option){
		if(typeof option == "undefined"){
			option = {};
		}
		/*那个对象动就设置哪个*/
		this.Touch = option.Touch || "#J-Touch";
		/*那个有数字的对象*/
		this.TouchIco=option.TouchIco || "#J-Touch-ico";
		
		/*此参数最好不要修改,目前木有考虑那么多*/
		this.Pagesize=option.Pagesize|| 1;
		
		/*位移的距离,其实就是指的是移动一个图片的宽度*/
		this.Width=option.Width || 720;
		/*下面数字的Current样式*/
		this.Current=option.Current|| "on";
		/*是否循环播放*/
		this.Continuous=option.Continuous || false;
		/*默认是否自动轮播 false*/
		this.isAuto=option.isAuto || false ;
		this.hasRight=option.hasRight || false;
		this.hasLeft=option.hasLeft || false;
		this.isEnable=true;
		this.timer=null;
		if(this.hasLeft){
			this.num=1;
		}else{
			this.num=0;
		}
		this.FastMoveTime=300;
		this.onMoveLeftEnd = option.onMoveLeftEnd;
		this.onMoveRightEnd = option.onMoveRightEnd;
		this.onPageChanged = option.onPageChanged;
		if(this.isAuto)
		{
			/*默认是否自动轮播间隔时间 3000 轮播之后可以设置,不轮播可以不用设置*/
			this.offSet=option.offSet || 3000;
		}
		this._fnStart();
		this._fnIsAuto();
		
		this._fnTouch(this.Touch.split("#")[1]);
	},
	_fnLength:function(){
		return $(this.Touch).find("li").length;
	},
	_fnMoveWidth:function(){
		return (this.Pagesize)*(this.Width);
	},
	_fnStart:function(){
		var _this=this,
		$ul=$(_this.Touch),
		$ulIco=$(_this.TouchIco),
		_Current=_this.Current,
		_moveWidth=_this._fnMoveWidth();
		/*初始化滚动内容的宽度和位置*/
		if(_this.hasLeft){
			$ul.css({"left":-_this.Width,width:(_this._fnLength())*(_this.Width)});
		}else{
			$ul.css({"left":0,width:(_this._fnLength())*(_this.Width)});
		}
		$ul.bind("mouseover touchstart",function(){
			clearTimeout(_this.timer);
			_this.timer=null;
		});	
		$ulIco.bind("mouseover touchstart",function(){
			clearTimeout(_this.timer);
			_this.timer=null;
		});		
		$ul.bind("mouseout touchend",function(){
			_this._fnIsAuto();
		});
		$ulIco.delegate("li","click touchstart",function(){
			var _index=$(this).index();
			_this.num=_index;		
			_this._fnAnimate($ul,-(_index*_moveWidth));
			_this._fnAddClass($ulIco.find("li"),_Current,_index);
		});
	},
	_fnAnimate:function(tag,i){
		//tag.stop(true,false).animate({"left":i},150);
		tag.stop(true,false).animate({"left":i},{easing: "easeOutQuad",duration: 150}); 
	},
	_fnAddClass:function(tag,className,i){
		var _this=this;
		if(_this.onPageChanged){
			_this.onPageChanged(i);
		}
	},
	/*是否自动轮播*/
	_fnIsAuto:function(){
		var _this=this;
		if(typeof _this.offSet=="undefined")
		{
			return false;
		}
		if(!_this.timer)
		{
			_this.timer=window.setTimeout(function(){_this._fnAuto();},_this.offSet);
		}
	},
	_fnAuto:function(){
		var _this=this;
		_this.num+=1;
		if(_this.num==_this._fnLength())
		{
			_this.num=0;
		}
		if(_this.num<_this._fnLength())
		{
			_this._fnAnimate($(_this.Touch),-(_this.num*(_this._fnMoveWidth())));
			_this._fnAddClass($(_this.TouchIco).find("li"),_this.Current,_this.num);
		}
		clearTimeout(_this.timer);
		_this.timer=window.setTimeout(function(){_this._fnAuto();},_this.offSet);
	},
	/*这里的下面全部是手机上面操作,比较粗糙不知道有木有更好的方式写*/
	_fnTouch:function(id){
		var _this=this,
			move=document.getElementById(id);
			_this._StartX=0;
			_this._StratY=0;
			_this._MoveX=0;
			_this._MoveY=0;
			/*记录手指点击屏幕时,屏幕轮播图此时的位置*/
			_this._temp=0;
			_this._StartT=0;
					_this._MoveT=0;
			
		move.addEventListener("touchstart",function(e){_this._fnTouchStart(e);}, false);
		move.addEventListener("touchmove",function(e){_this._fnTouchMove(e);}, false);
		move.addEventListener("touchend",function(e){_this._fnTouchEnd(e);}, false);
	},
	/*手指每次点击在屏幕上的位置X,Y 多点触屏*/
	_fnTouchX:function(e){
		var touches = e.changedTouches,
		i = 0, l = touches.length, touch,tagX;
		for (; i < l; i++) {
			touch = touches[i];
			tagX=touch.pageX;
		}
		return tagX;
	},
	_fnTouchY:function(e){
		var touches = e.changedTouches,
		i = 0, l = touches.length, touch,tagY;
		for (; i < l; i++) {
			touch = touches[i];
			tagY=touch.pageY;
		}
		return tagY;
	},
	_fnTouchStart:function(e){
		var _this=this;
		_this._StartX=_this._fnTouchX(e);
		_this._StartY=_this._fnTouchY(e);
		/*记录手指点击屏幕时,屏幕轮播图此时的位置 在这里初始化*/
		_this._temp=$(_this.Touch).position().left;
		_this._StartT=new Date().getTime();
	},
	_fnTouchMove:function(e){
		var _this=this;
		if(!_this.isEnable){
			return;
		}
		_this._MoveX=_this._fnTouchX(e)-_this._StartX;
		_this._MoveY=_this._fnTouchY(e)-_this._StartY;
		/*这里是为了手指一定是横向滚动的*/
		if(Math.abs(_this._MoveY)<Math.abs(_this._MoveX))
		{
			e.preventDefault();
			e.stopPropagation();//阻止pageScroll的冒泡
			myScroll.disable();
			var moveX=_this._temp+_this._MoveX;
			$(_this.Touch).css({"left":moveX+"px"});
		}else{
			var moveX=(_this.num)*(_this._fnMoveWidth());
			_this._fnAnimate($(_this.Touch),-moveX);
			_this._fnAddClass($(_this.TouchIco).find("li"),_this.Current,_this.num);
		}
	},
	_fnTouchEnd:function(e){
		var _this=this;
		if(!_this.isEnable){
			return;
		}
		/*手指离开之后，手开始到结束的距离*/
		_this._MoveX=_this._fnTouchX(e)-_this._StartX;
		_this._MoveY=_this._fnTouchY(e)-_this._StartY;
		_this._MoveT=new Date().getTime()-_this._StartT;
		if(_this._MoveT<_this.FastMoveTime){
			_this._MoveX = _this._MoveX*10;
		}
		myScroll.enable();
		if(Math.abs(_this._MoveY)<Math.abs(_this._MoveX)){
			e.stopPropagation();//阻止pageScroll的冒泡
			if(Math.abs(_this._MoveX)>(_this.Width/7)&&_this.num==1&&_this._MoveX>0&&_this.hasLeft){
				_this._fnAnimate($(_this.Touch),-_this.Width*(_this.num-1/7));
				if(_this.onMoveLeftEnd){
						_this._fnAnimate($(_this.Touch),-_this.Width*_this.num);
						_this.onMoveLeftEnd();
				}
			}else if(Math.abs(_this._MoveX)>(_this.Width/7)&&_this.num==(_this._fnLength()-2)&&_this._MoveX<0&&_this.hasRight){
				_this._fnAnimate($(_this.Touch),-_this.Width*(_this.num+1/7));
				if(_this.onMoveRightEnd){
					_this._fnAnimate($(_this.Touch),-_this.Width*_this.num);
					_this.onMoveRightEnd();
				}
			}else{
				if(Math.abs(_this._MoveX)>(_this.Width/2)){
					e.preventDefault();
					/*这里就是方向问题判断 向右*/
					if(_this._MoveX>0){	
						_this.num--;
						if(_this.num>=0){
							var moveX=(_this.num)*(_this._fnMoveWidth());
							_this._fnAnimate($(_this.Touch),-moveX);
							_this._fnAddClass($(_this.TouchIco).find("li"),_this.Current,_this.num);
						}else{
							//缓冲区域
							if(this.Continuous){
								_this.num=_this._fnLength()-1;
								this._fnAnimate($(_this.Touch),-(_this.num*(_this._fnMoveWidth())));
								_this._fnAddClass($(_this.TouchIco).find("li"),_this.Current,_this.num);
							}else{
								this._fnAnimate($(_this.Touch),0);
								_this.num=0;
							}
						}
					}else{
						/*这里就是方向问题判断 向左*/
						_this.num++;
						if(_this.num<_this._fnLength() && _this.num>=0){
							var moveX=(_this.num)*(_this._fnMoveWidth());
							_this._fnAnimate($(_this.Touch),-moveX);
							_this._fnAddClass($(_this.TouchIco).find("li"),_this.Current,_this.num);
						}else{
							//缓冲区域
							if(this.Continuous){
								_this.num=0;
								this._fnAnimate($(_this.Touch),-(_this.num*(_this._fnMoveWidth())));
								_this._fnAddClass($(_this.TouchIco).find("li"),_this.Current,_this.num);
							}else{
								_this.num=_this._fnLength()-1;
								this._fnAnimate($(_this.Touch),-(_this.num*(_this._fnMoveWidth())));
							}
						}
					}
				}else{
					var moveX=(_this.num)*(_this._fnMoveWidth());
					_this._fnAnimate($(_this.Touch),-moveX);
					_this._fnAddClass($(_this.TouchIco).find("li"),_this.Current,_this.num);
				}
			}
		}
	}
};	
})(window);