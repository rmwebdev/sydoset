<div id="main-menu" class="main-menu collapse navbar-collapse" >
    <ul class="nav navbar-nav" >
        @php
            $a = json_decode($menu);
        @endphp
        @for ($i = 0; $i < count($a); $i++)
            @if(!array_key_exists('children', $a[$i]))
                <li class="menu-item-has-children dropdown">
                    <a href="{{$a[$i]->url}}"><img src="{{$a[$i]->menu_icon}}" style="width:17px;height:16px;margin-right:10px"></img>{{$a[$i]->menu_name}}</a>
                </li>
            @else
                @php
                    $child = $a[$i]->children;
                    $validate = '';
                    $bbol = 'false';
                    if(array_search(Request::path(), array_column($a[$i]->children, 'url')) !== False){
                        $validate = 'show';
                        $bbol = 'false';
                    }
                @endphp
                <li class="menu-item-has-children dropdown {{ $validate }}">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="{{ $bbol }}"><img src="{{$a[$i]->menu_icon}}" style="width:17px;height:16px;margin-right:10px"></img>{{$a[$i]->menu_name}}</a>
                    <ul class="sub-menu children dropdown-menu {{ $validate }}">           
                        @for($j = 0; $j < count($child); $j++)                 
                        <li class="{{ Request::path() == $child[$j]->url ? 'active' : '' }}"><a href="/{{$child[$j]->url}}">{{$child[$j]->menu_name}}</a></li>
                        @endfor
                    </ul>
                </li>

            @endif
        @endfor
        <li class="parent">
            <a href="/logout"><img src="{{asset('icon/icon_login.png')}}" style="width:17px;height:16px;margin-right:10px"></img>Keluar</a>
        </li>
    </ul>
</div><!-- /.navbar-collapse -->
