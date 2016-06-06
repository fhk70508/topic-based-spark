package hsueh


import java.io.{BufferedWriter, File, OutputStreamWriter, PrintWriter}
import java.net.{URI, URL}
import java.text.SimpleDateFormat
import java.util.{Calendar, Date}
import javax.mail.Message.RecipientType

import org.apache.hadoop.conf.Configuration
import org.apache.hadoop.fs.{FSDataOutputStream, FileSystem, Path}
import org.apache.spark.storage.StorageLevel
import org.apache.spark.streaming.{Seconds, StreamingContext}
import org.apache.spark.{SparkConf, SparkContext}
import org.codemonkey.simplejavamail.{Email, Mailer, TransportStrategy}
import org.jsoup.Jsoup


/**
 * Hello world!
 *
 */
object App  {
  def main(args: Array[String]): Unit ={
    val event = ("表演活動","免費","06-23","【山海之間‧轉跡】金工藝術展, ,邀請您前來感受 溫暖的傳承與感動！","石雕博物館2樓文創意廊","http://www.hccc.gov.tw/Utility/DisplayImage?id=14500&prefix=normal_prop_","http://www.hccc.gov.tw/zh-tw/Activity/Detail/5417")
    val email = new Email()
    email.setFromAddress("test","test@gmail.com")
    email.addRecipient("user name","j100266422@gmail.com",RecipientType.TO)
    email.setSubject("new Event")
    email.setText(event._1+","+event._2+","+event._3+","+event._4+","+event._5)
    email.setTextHTML("<tr> <td><img src="+event._6+"></td>" +
      "<td><p><a href ="+event._7+">"+event._4+"</a></p>" +
      "<p>活動類別："+event._1+"</p>" +
      "<p>活動地點："+event._5+"</p>" +
      "<p>活動時間到："+event._3+"</p>" +
      "<p>"+event._2);

    //new Mailer("smtp.gmail.com",465,"account","password,TransportStrategy.SMTP_SSL).sendMail(email)

    //-----------get day--------
     var DATE_FORMATE = "yyyy-MM-dd"
     var sdf = new SimpleDateFormat(DATE_FORMATE)
     var sysday = Calendar.getInstance()
     sysday.setTime(new Date)
     sysday.add(Calendar.DAY_OF_YEAR,1)
     var tomorrow = sdf.format(sysday.getTime)
     //print(tomorrow)
     //----------------------------------
   //val url = new URL("http://www.hccc.gov.tw/Portal/Content.aspx?lang=0&p=003010001&type=0&date="+tomorrow)
     val url = new URL("http://www.hccc.gov.tw/zh-tw/Activity/Calendar/"+tomorrow)
   var doc = Jsoup.parse(url, 3000)
   var page = doc.select("div.pagesNum")


     var pagecount = -2
     var abshref = page.select("a")
     var iterator = abshref.iterator()
     var why = doc.select("table.table_newsList_01")
     //println(why.select("tr>td>p>a").text())
     while(iterator.hasNext)
     {
       println(iterator.next().attr("abs:href"))
       pagecount = pagecount +1
     }
     if(pagecount < 0 ) pagecount = 1

     val pw = new PrintWriter(new File("/home/wise/place/"+ Calendar.getInstance().getTime))

     for(i <- 1 to  pagecount){
       var html = new URL("http://www.hccc.gov.tw/zh-tw/Activity/Calendar/"+tomorrow+"/"+i)
       var newdoc = Jsoup.parse(html, 3000)
       var alltable = newdoc.select("table.table_newsList_01")
       var allevent = alltable.select("tr")
       var alla = allevent.select("a").text()        //活動名稱
       var alltitle = allevent.select("p.act-type>span").text()  //活動類型
       var alldate = allevent.select("p.act-time")   //活動時間
       var alladdr = allevent.select("p.act-pos")    //活動地點
       var allspend = allevent.select("p.act-ticket>img")  //活動花費


       var aiterator = allevent.iterator()
       while(aiterator.hasNext) {
         var event = aiterator.next()
         //活動類型//活動花費//活動時間//活動名稱//活動地點//活動圖片//活動連結
         var a = event.select("p.act-type>span")  //活動類型
         var spend = event.select("p.act-ticket>img").attr("alt")  //活動花費
         var date = event.select("p.act-time")   //活動時間

         var title = event.select("a").attr("title")   //活動名稱
         var addr = event.select("p.act-pos")   //活動地點

         val titleimg = event.select("img").attr("abs:src") //活動圖片
         var titlehref = event.select("a").attr("abs:href")    //活動連結

   //展覽活動,免費,2015-08-30,經典雜誌攝影展《咱ㄟ社區》,將軍府 (縣定古蹟暨歷史建築美崙溪畔日式宿舍),http://www.hccc.gov.tw/Image.ashx?attr=eyJ0YWciOiJhY3Rpdml0eUltYWdlIiwiaWQiOiIxMzk4IiwidGh1bWIiOnRydWUsImZpbGVuYW1lIjoiaW1hZ2UzNjQ0Mjk5NDY4OTkzLmpwZyIsImRlZkltZyI6InBob3RvXzIwMHgxNTAuanBnIn0%3d,http://www.hccc.gov.tw/Portal/Content.aspx?lang=0&p=003020301&u=Detail&type=1&index=1&id=1398
         pw.write(
         a.text()+"$"+spend+"$"+date.text().substring(16)+"$"+
           title+"$"+addr.text().substring(5)+"$"+titleimg+"$"+titlehref+"\n")
       }

         println("-----------change page------------")

      //------------------hdfs write file ---------
       /*
       val conf = new Configuration()
       val uriFile = "hdfs://localhost:9000/test.txt"

       val fs = FileSystem.get(URI.create(uriFile),conf)
       val file = new Path(uriFile)

       val fsStream = fs.create(file)
       val out =
         new BufferedWriter(new OutputStreamWriter(fsStream,"UTF-8"))
       out.write(a.text()+"$"+spend+"$"+date.text().substring(16)+"$"+
           title+"$"+addr.text().substring(5)+"$"+titleimg+"$"+titlehref+"\n")
       out.flush()
       out.close()
       fsStream.close()*/
      //----------------------------------------------//
     }
       pw.close

  }

}
