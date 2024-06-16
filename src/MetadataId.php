<?php

class MetadataId
{
    const MetadataNameTable = 0x200;

    const LicenseDat = 0x400;       // license.dat
    const LicenseInfo = 0x401;      // license.info
    const NpTitleDat = 0x402;       // nptitle.dat
    const NpBindDat = 0x403;        // npbind.dat
    const SelfInfoDat = 0x404;      // selfinfo.dat
    const ImageInfoDat = 0x406;     // imageinfo.dat

    const ParamSfo = 0x1000;            // param.sfo
    const PlaygoChunkDat = 0x1001;      // playgo-chunk.dat
    const PlaygoChunkSha = 0x1002;      // playgo-chunk.sha
    const PlaygoManifestXml = 0x1003;   // playgo-manifest.xml
    const PronunciationXml = 0x1004;    // pronunciation.xml
    const PronunciationSig = 0x1005;    // pronunciation.sig
    const Pic1Png = 0x1006;             // pic1.png
    const PubToolInfoDat = 0x1007;      // pubtoolinfo.dat
    const AppPlaygoChunkDat = 0x1008;   // app/playgo-chunk.dat
    const AppPlaygoChunkSha = 0x1009;   // app/playgo-chunk.sha
    const AppPlaygoManifestXml = 0x100A;// app/playgo-manifest.xml

    const ChangeInfo_Xml = 0x1260;      // changeinfo/changeinfo.xml
    const ChangeInfo_00_Xml = 0x1261;   // changeinfo/changeinfo_00.xml
    const ChangeInfo_01_Xml = 0x1262;
    const ChangeInfo_02_Xml = 0x1263;
    const ChangeInfo_03_Xml = 0x1264;
    const ChangeInfo_04_Xml = 0x1265;
    const ChangeInfo_05_Xml = 0x1266;
    const ChangeInfo_06_Xml = 0x1267;
    const ChangeInfo_07_Xml = 0x1268;
    const ChangeInfo_08_Xml = 0x1269;
    const ChangeInfo_09_Xml = 0x126A;
    const ChangeInfo_10_Xml = 0x126B;
    const ChangeInfo_11_Xml = 0x126C;
    const ChangeInfo_12_Xml = 0x126D;
    const ChangeInfo_13_Xml = 0x126E;
    const ChangeInfo_14_Xml = 0x126F;
    const ChangeInfo_15_Xml = 0x1270;
    const ChangeInfo_16_Xml = 0x1271;
    const ChangeInfo_17_Xml = 0x1272;
    const ChangeInfo_18_Xml = 0x1273;
    const ChangeInfo_19_Xml = 0x1274;
    const ChangeInfo_20_Xml = 0x1275;
    const ChangeInfo_21_Xml = 0x1276;
    const ChangeInfo_22_Xml = 0x1277;
    const ChangeInfo_23_Xml = 0x1278;
    const ChangeInfo_24_Xml = 0x1279;
    const ChangeInfo_25_Xml = 0x127A;
    const ChangeInfo_26_Xml = 0x127B;
    const ChangeInfo_27_Xml = 0x127C;
    const ChangeInfo_28_Xml = 0x127D;
    const ChangeInfo_29_Xml = 0x127E;
    const ChangeInfo_30_Xml = 0x127F;

    // PS5 Specific
    const Trophy2Trophy00Ucp = 0x1480;  // trophy2/trophy00.ucp
    const UdsUds00Ucp = 0x14A0;         // uds/uds00.ucp

    const ParamJson = 0x2000;           // param.json
    const PlaygoHashTableDat = 0x2010;  // playgo-hash-table.dat
    const PlaygoFicmDat = 0x2011;       // play-go-ficm.dat

    const UdsNpBindDat = 0x2020;        // uds/npbind.dat
    const Trophy2NpBindDat = 0x2021;    // trophy2/npbind.dat

    const Pic2Png = 0x2040;             // pic2.png
    const Pic2Dds = 0x2060;             // pic2.dds

    const OriginParamJson = 0x2100;     // origin-param.json
    const TargetParamJson = 0x2101;     // target-param.json
}