@extends('client.layouts.app')
@section('title', 'Refund Policy Quick Dials- Local search, IT Training, Service, overseas education')
@section('description', 'Refund Policy Dials- Local search, IT Training, Service, overseas education')
@section('keyword', 'Refund Policy Dials- Local search, IT Training, Service, overseas education')

@section('content')
<div class="about-bg page-hearder-area">
    <div class="official-overly"></div> 
  </div>  
 
  <div class="blog-page area-padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <div class="page-head-blog">
            <div class="single-blog-page">
      
            </div>
            <div class="single-blog-page">
              <!-- recent start -->
              <div class="left-blog">
                <h4>Recent Post Blog</h4>
                <div class="recent-post">
                  <!-- start single post -->
                       @if(!empty($blogrecents))
					 @foreach($blogrecents as $blogrecent)
						<?php 
						if($blogrecent->image!=''){
						$image = unserialize($blogrecent->image);					 
						$image = $image['large']['src'];
						}
						?>
				  <div class="recent-single-post">
                    <div class="post-img">
					<a href="{{url('blog/'.$blogrecent->slug)}}">
					  <img loading="lazy" src="<?php echo (isset($image)?url($image):"");  ?>" width="96px" height="72px" title="{{$blogrecent->name}}" alt="{{$blogrecent->name}}">
					</a>
                    </div>
                    <div class="pst-content">
                      <p><a href="{{url('blog/'.$blogrecent->slug)}}"><?php echo ucfirst(substr($blogrecent->description,0,50));?> .</a></p>
                    </div>
                  </div>
				    @endforeach
				  @endif
                
                 
                </div>
              </div>
             
            </div>
            <!--<div class="single-blog-page">
              <div class="left-blog">
                <h4>categories</h4>
                <ul>
                  <li>
                    <a href="javascript:void(0)">Portfolio</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Project</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Design</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">wordpress</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Joomla</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Html</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">Website</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="single-blog-page">
              <div class="left-blog">
                <h4>archive</h4>
                <ul>
                  <li>
                    <a href="javascript:void(0)">07 July 2016</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">29 June 2016</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">13 May 2016</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">20 March 2016</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)">09 Fabruary 2016</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="single-blog-page">
              <div class="left-tags blog-tags">
                <div class="popular-tag left-side-tags left-blog">
                  <h4>popular tags</h4>
                  <ul>
                    <li>
                      <a href="javascript:void(0)">Portfolio</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">Project</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">Design</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">Website</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">Joomla</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">Html</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">wordpress</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">Masonry</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>-->
          </div>
        </div>
        <!-- End left sidebar -->
        <!-- Start single blog -->
        <div class="col-md-8 col-sm-8 col-xs-12">
          <div class="row">
                  <div class="single-blog-page">
              <div class="left-tags blog-tags">
                <div class="popular-tag left-side-tags left-blog">
                  <h4>RSS  Choose Your News Feeds</h4>
				  
				  <div class="">
				  <h5>What Is RSS?</h5>
				  <p>RSS stands for Really Simple Syndication. It refers to files easily read by a computer called XML files that automatically update information.</p>

<p>This information is fetched by a user’s RSS feed reader that converts the files into the latest updates from websites in an easy to read format. It feeds you headlines, summaries, update notices, and links back to articles on your favorite website’s page.</p>
<p>
This content is distributed in real time, so that the top results on the RSS feed are always the latest published content for a website.</p>
<p>
An RSS feed allows you to create your own customized eZine of the most up-to-date content for the topics and websites you are interested about.</p>
				  
				  </div>
                  <ul>
                    <li>
                      <a href="https://www.amity.edu/"><i class="fa fa-rss"></i> Amity University</a>
                    </li>
                    <li>
                      <a href="http://www.du.ac.in/du/"><i class="fa fa-rss"></i> Delhi university</a>
                    </li>
                    <li>
                      <a href="https://aktu.ac.in/"><i class="fa fa-rss"></i> A.P.J. Abdul Kalam TUUP</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"><i class="fa fa-rss"></i>Website</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"><i class="fa fa-rss"></i>Joomla</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"><i class="fa fa-rss"></i>Html</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"><i class="fa fa-rss"></i>wordpress</a>
                    </li>
                    <li>
                      <a href="javascript:void(0)"><i class="fa fa-rss"></i>Masonry</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div> 
		 
             
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Blog Area -->

  <div class="clearfix"></div>
 @endsection
