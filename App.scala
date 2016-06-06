package hsueh

import javax.mail.Message.RecipientType

import org.apache.spark.storage.StorageLevel
import org.apache.spark.streaming.{Seconds, StreamingContext}
import org.apache.spark.{SparkConf, SparkContext}
import org.codemonkey.simplejavamail.{Email, Mailer, TransportStrategy}

/**
 * Hello world!
 *
 */
object App {
  def createContext(ip: String, port: Int, filelocation : String,checkpointDirectory: String, mailaccount: String, password :String) = {
    val conf = new SparkConf().setMaster("local[*]").setAppName("streaming project")  //setMaster==spark://...
    val sc = new SparkContext(conf)
    val ssc = new StreamingContext(sc, Seconds(90))//週期時間
    ssc.checkpoint(checkpointDirectory)

    val addFunc = (currValues: Seq[String], prevValueState: Option[String]) => {
      val currentCount = currValues.size
      val previousCount = prevValueState.getOrElse("")
      if(currentCount == 0) Some(previousCount)
      else Some(currValues.last)
    }

    val lines = ssc.socketTextStream("localhost", 1234, StorageLevel.MEMORY_AND_DISK_SER)
    val pairs = lines.map{word => val a = word.split(",")
      val b = a.size
      ((a(b-2),a(b-1)),word)}
    //user = ((name,email),lines)
    val totalWordCounts = pairs.updateStateByKey[String](addFunc)
    //-----使用者訂閱資訊-----//
    val count = totalWordCounts.flatMap{x =>
      val a = x._2.split("'")
      val b = a(0).split(",")
      val c = a(1).split(",")
      val d = a(2).split(",")
      var count = List[((String,String),(String,String))]()
      for(j <- b)for(k <- c){var n = ((j,k),(d(0),d(1)));
        count = count.::(n);}
      (count)
    }//---------------------//

    //-----資料比對-----//
    val event = ssc.socketTextStream("localhost",12345,StorageLevel.MEMORY_AND_DISK_SER)
      //textFileStream("/home/wise/place")
        .map(line => line.split("$")).
      map(word => (
      (word(0),word(1)) ,(word(0),word(1),word(2),word(3),word(4),word(5),word(6)))  )
    val a = count.join(event)
    a.foreachRDD{rdd =>
      rdd.foreach{record =>
        val user = record._2._1
        val event = record._2._2
        val email = new Email()
        email.setFromAddress("test","test@gmail.com")
        email.addRecipient(user._1,user._2,RecipientType.TO)
        email.setSubject("new Event")
        email.setText(event._1+","+event._2+","+event._3+","+event._4+","+event._5)
        email.setTextHTML("<tr> <td><img src="+event._6+"></td>" +
          "<td><p><a href ="+event._7+">"+event._4+"</a></p>" +
          "<p>活動類別："+event._1+"</p>" +
          "<p>活動地點："+event._5+"</p>" +
          "<p>活動時間到："+event._3+"</p>" +
          "<p>"+event._2);

        new Mailer("smtp.gmail.com",465,mailaccount,password,TransportStrategy.SMTP_SSL).sendMail(email)

      }}

    ssc
  }
  def main(args: Array[String]) {
    if (args.length < 3) {
      System.err.println("Need Arguments:  <hostname> <port> <file location> <checkpoint location> <mail account> <password>")
      System.exit(1)
    }
    val Filelocation = args(3)
    val ssc = StreamingContext.getOrCreate(Filelocation,
      () => {
        createContext(args(0), args(1).toInt, args(2), Filelocation, args(4),args(5))
      })

    ssc.start()
    ssc.awaitTermination()
  }
}
